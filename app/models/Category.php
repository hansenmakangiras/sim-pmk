<?php

use yajra\Oci8\Eloquent\OracleEloquent as Eloquent;
use Illuminate\Support\Facades\URL;

class Category extends Eloquent {

    // define binary/blob fields used for Oracle DB
    protected $binaries = ['content'];

    /**
     * Deletes a blog post and all
     * the associated comments.
     *
     * @return bool
     */
    public function delete()
    {
        // Delete the categories
        $this->categories()->delete();

        // Delete the blog post
        return parent::delete();
    }

    /**
     * Returns a formatted post content entry,
     * this ensures that line breaks are returned.
     *
     * @return string
     */
    public function content()
    {
        return nl2br($this-> content);
    }

    /**
     * Get the categories author.
     *
     * @return User
     */
    public function author()
    {
        return $this->belongsTo('User', 'user_id');
    }

    /**
     * Get the post's categories.
     *
     * @return array
     */
    public function post()
    {
        return $this->hasmany('Post');
    }

    /**
     * Get the date the post was created.
     *
     * @param \Carbon|null $date
     * @return string
     */
    public function date($date=null)
    {
        if(is_null($date)) {
            $date = $this->created_at;
        }

        return String::date($date);
    }

    /**
     * Get the URL to the post.
     *
     * @return string
     */
    public function url()
    {
        return Url::to($this->slug);
    }

    /**
     * Returns the date of the blog post creation,
     * on a good and more readable format :)
     *
     * @return string
     */
    public function created_at()
    {
        return $this->date($this->created_at);
    }

    /**
     * Returns the date of the blog post last update,
     * on a good and more readable format :)
     *
     * @return string
     */
    public function updated_at()
    {
        return $this->date($this->updated_at);

    }

}
