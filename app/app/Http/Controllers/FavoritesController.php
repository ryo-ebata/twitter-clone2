<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{

    /**
     * isFavorite()でいいねの有無をチェックして、していなければいいねする。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Favorite $favorite)
    {
        $user = auth()->user();
        $tweet_id = $request->tweet_id;
        $is_favorite = $favorite->isFavorite($user->id, $tweet_id);
        sleep(1);

        if(!$is_favorite){
            $favorite->storeFavorite($user->id, $tweet_id);
        }
        return back();
    }


    /**
     * いいねしているかチェックして、いいねを外す。
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        $user_id = $favorite->user_id;
        $tweet_id = $favorite->tweet_id;
        $favorite_id = $favorite->id;
        $is_favorite = $favorite->isFavorite($user_id, $tweet_id);

        if($is_favorite) {
            $favorite->destroyFavorite($favorite_id);
        }
        return back();
    }
}