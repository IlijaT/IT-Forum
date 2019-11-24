<?php

namespace App;

trait Favoritable
{

  public function favorites()
  {
    return $this->morphMany(Favorite::class, 'favorited');
  }

  public function favorite()
  {
    if (!$this->favorites()->where('user_id', auth()->id())->exists()) {
      return $this->favorites()->create(['user_id' => auth()->id()]);
    }
  }

  public function getIsFavoritedAttribute()
  {
    return $this->isFavorited();
  }

  public function unfavorite()
  {

    $this->favorites()->where('user_id', auth()->id())->delete();
  }

  public function isFavorited()
  {
    return !!$this->favorites->where('user_id', auth()->id())->count();
  }

  public function getFavoritesCountAttribute()
  {
    return $this->favorites->count();
  }
}