<?php

namespace App\Service;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function store($data){
        try {
            DB::beginTransaction();
            $tagIds = $data['tag_ids'];
            unset($data['tag_ids']);
            //шлях до картинок в бд зі збереженням клучів
            $data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
            $data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);

            // якщо хочемо, дати можливість додання поста без тегів
            //$post->tags()->sync((isset($data['tag_ids']))? $data['tag_ids'] : []);
            $post = Post::firstOrCreate($data);
            $post->tags()->attach($tagIds);
            DB::commit();
        } catch (\Exception $exception){
            DB::rollBack();
            abort(500);
        }
    }

    public function update($data, $post){
        try {
            DB::beginTransaction();
            $tagIds = $data['tag_ids'];
            unset($data['tag_ids']);
            //шлях до картинок в бд зі збереженням ключів
            if (array_key_exists('preview_image', $data)) {
                $data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
            }
            if (array_key_exists('main_image', $data)) {
                $data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);
            }
            $post->update($data);
            // якщо хочемо, дати можливість додання поста без тегів
            //$post->tags()->sync((isset($data['tag_ids']))? $data['tag_ids'] : []);
            // sync - видаляє всі привязки які в нас є і добавляє тільки ті які ми вказали
            $post->tags()->sync($tagIds);
            DB::commit();
        } catch (\Exception $exception){
            DB::rollBack();
            abort(500);
        }
        return $post;
    }

}