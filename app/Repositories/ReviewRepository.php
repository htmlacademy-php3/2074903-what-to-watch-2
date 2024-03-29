<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Factories\Dto\Dto;
use App\Factories\Dto\ReviewDto;
use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function all(
        array $columns = ['*'],
        int $limit = self::DEFAULT_LIMIT,
        int $offset = self::DEFAULT_OFFSET
    ): Collection {
        return Review::query()->limit($limit)->offset($offset)->get($columns);

    }

    /**
     * @param int $id
     * @param Dto $dto
     * @return Model
     * @throws InternalErrorException
     */
    public function update(int $id, Dto $dto): Model
    {
        $review = Review::whereId($id)->firstOrFail();
        /** @var ReviewDto $reviewDto */
        $reviewDto = $dto;

        if ($reviewDto->text) {
            $review->text = $reviewDto->text;
        }

        if ($reviewDto->rating) {
            $review->rating = $reviewDto->rating;
        }

        if (!$review->save()) {
            throw new InternalErrorException('The error on the server, please, try again', 500);
        }

        return $review;
    }

    public function delete(int $id): void
    {
        $review = Review::whereId($id)->firstOrFail();
        $review->delete();
    }

    public function findById(int $id, array $columns = ['*']): Model
    {
        return $this->findBy('id', $id, $columns);
    }

    public function findBy(string $field, mixed $value, array $columns = ['*']): Model
    {
        return Review::with([
            'comments',
        ])->where($field, '=', $value)->firstOrFail($columns);
    }

    public function allForFilm(
        int $filmId,
        array $columns = ['id', 'text', 'created_at', 'rating', 'user_id'],
        int $limit = self::DEFAULT_LIMIT,
        int $offset = self::DEFAULT_OFFSET
    ): Collection {
        return Review::with([
            'user:id,name'
        ])
            ->select($columns)
            ->where('film_id', '=', $filmId)
            ->orderBy(Review::REVIEW_DEFAULT_ORDER_BY, Review::REVIEW_DEFAULT_ORDER_TO)
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    public function deleteChildReviews(int $reviewId): void
    {
        $comments = Review::query()->where('review_id', '=', $reviewId)->get();

        foreach ($comments as $comment) {
            $comment->delete();
        }
    }
}
