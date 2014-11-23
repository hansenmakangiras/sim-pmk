<?php

class AdminCategoriesController extends AdminController
{

    /**
     * Comment Model
     * @var Comment
     */
    protected $category;

    /**
     * Inject the models.
     * @param Comment $category
     */
    public function __construct(Comment $category)
    {
        parent::__construct();
        $this->category = $category;
    }

    /**
     * Show a list of all the comment posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/categories/title.category_management');

        // Grab all the comment posts
        $categories = $this->category;

        // Show the page
        return View::make('admin/categories/index', compact('categories', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $category
     * @return Response
     */
    public function getEdit($category)
    {
        // Title
        $title = Lang::get('admin/categories/title.category_update');

        // Show the page
        return View::make('admin/categories/edit', compact('category', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $category
     * @return Response
     */
    public function postEdit($category)
    {
        // Declare the rules for the form validation
        $rules = array(
            'category' => 'required|min:3'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the comment post data
            $category->category = Input::get('category');

            // Was the comment post updated?
            if($category->save())
            {
                // Redirect to the new comment post page
                return Redirect::to('admin/categories/' . $category->id . '/edit')->with('success', Lang::get('admin/categories/messages.update.success'));
            }

            // Redirect to the comments post management page
            return Redirect::to('admin/categories/' . $category->id . '/edit')->with('error', Lang::get('admin/categories/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/categories/' . $category->id . '/edit')->withInput()->withErrors($validator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $category
     * @return Response
     */
    public function getDelete($category)
    {
        // Title
        $title = Lang::get('admin/categories/title.category_delete');

        // Show the page
        return View::make('admin/categories/delete', compact('category', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $category
     * @return Response
     */
    public function postDelete($category)
    {
        // Declare the rules for the form validation
        $rules = array(
            'id' => 'required|integer'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            $id = $category->id;
            $category->delete();

            // Was the comment post deleted?
            $category = Comment::find($id);
            if(empty($category))
            {
                // Redirect to the comment posts management page
                return Redirect::to('admin/categories')->with('success', Lang::get('admin/categories/messages.delete.success'));
            }
        }
        // There was a problem deleting the comment post
        return Redirect::to('admin/categories')->with('error', Lang::get('admin/categories/messages.delete.error'));
    }

    /**
     * Show a list of all the comments formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $categorys = Comment::leftjoin('posts', 'posts.id', '=', 'categories.post_id')
            ->leftjoin('users', 'users.id', '=','categories.user_id' )
            ->select(array('categories.id as id', 'posts.id as postid','users.id as userid', 'categories.category', 'posts.title as post_name', 'users.username as poster_name', 'categories.created_at'));

        return Datatables::of($categorys)
            ->edit_column('created_at', '{{ $created_at->format("Y-m-d h:i:s") }}')
            ->edit_column('category', '<a href="{{{ URL::to(\'admin/categories/\'. $id .\'/edit\') }}}" class="iframe cboxElement">{{{ Str::limit($content, 40, \'...\') }}}</a>')
            ->edit_column('post_name', '<a href="{{{ URL::to(\'admin/blogs/\'. $postid .\'/edit\') }}}" class="iframe cboxElement">{{{ Str::limit($post_name, 40, \'...\') }}}</a>')
            ->edit_column('poster_name', '<a href="{{{ URL::to(\'admin/users/\'. $userid .\'/edit\') }}}" class="iframe cboxElement">{{{ $poster_name }}}</a>')
            ->add_column('actions', '
            <div class="btn-group">
            <a href="{{{ URL::to(\'admin/categories/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-primary btn-xs"><i class="fa fa-pencil"></i> {{{ Lang::get(\'button.edit\') }}}</a>
            <a href="{{{ URL::to(\'admin/categories/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> {{{ Lang::get(\'button.delete\') }}}</a>
            </div>
            ')
            ->remove_column('id')
            ->remove_column('postid')
            ->remove_column('userid')
            ->remove_column('rn') // rownum for oracle
            ->make();
    }

}
