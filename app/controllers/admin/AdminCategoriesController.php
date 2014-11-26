<?php

class AdminCategoriesController extends AdminController
{

    /**
     * Category Model
     * @var Category
     */
    protected $category;

    /**
     * Inject the models.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct();
        $this->category = $category;
    }

    /**
     * Show a list of all the Category posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/categories/title.category_management');

        // Grab all the Category posts
        $categories = $this->category;

        // Show the page
        return View::make('admin/categories/index', compact('categories', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        // Title
        $title = Lang::get('admin/categories/title.create_a_new_category');

        // Show the page
        return View::make('admin/categories/create_edit', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
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
            // Create a new category post
            $user = Auth::user();

            // Update the blog post data
            $this->category->category          = Input::get('category');
            $this->category->user_id          = $user->id;

            // Was the category post created?
            if($this->post->save())
            {
                // Redirect to the new category post page
                return Redirect::to('admin/categories/' . $this->category->id . '/edit')->with('success', Lang::get('admin/categories/messages.create.success'));
            }

            // Redirect to the category post create page
            return Redirect::to('admin/categories/create')->with('error', Lang::get('admin/categories/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/categories/create')->withInput()->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param $category
     * @return Response
     */
    public function getShow($category)
    {
        // redirect to the frontend
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
                // Redirect to the new category post page
                return Redirect::to('admin/categories/' . $category->id . '/edit')->with('success', Lang::get('admin/categories/messages.update.success'));
            }

            // Redirect to the category post management page
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
            $category = Category::find($id);
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
        $categories = Category::select(array('categories.id', 'categories.category', 'categories.id as Posts', 'categories.created_at'));

        return Datatables::of($categories)
            ->edit_column('created_at', '{{ $created_at->format("Y-m-d h:i:s") }}')
            ->edit_column('posts', '{{ DB::table(\'posts\')->where(\'id\', \'=\', $id)->count() }}')
            ->add_column('actions', '
            <div class="btn-group">
                <a href="{{{ URL::to(\'admin/categories/\' . $id . \'/edit\' ) }}}" class="btn btn-primary btn-xs iframe" ><i class="fa fa-pencil"></i> {{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/categories/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe"><i class="fa fa-trash-o"></i> {{{ Lang::get(\'button.delete\') }}}</a>
            </div>
            ')
            ->remove_column('id')
            ->remove_column('rn') // rownum for oracle
            ->make();
    }

}
