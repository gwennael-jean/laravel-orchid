<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use DateTimeInterface;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property bool $enabled
 * @property bool $draft
 * @property bool $sticky
 * @property DateTimeInterface $published_at
 */
class Post extends Model
{
    use HasFactory, AsSource;
}
