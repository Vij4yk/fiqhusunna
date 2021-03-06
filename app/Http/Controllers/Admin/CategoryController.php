<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Src\Category\CategoryRepository;
use App\Src\Photo\PhotoRepository;
use App\Src\Track\TrackManager;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var TrackUploader
     */
    private $trackManager;

    /**
     * @param CategoryRepository $categoryRepository
     * @param TrackManager $trackManager
     */
    public function __construct(CategoryRepository $categoryRepository, TrackManager $trackManager)
    {
        $this->categoryRepository = $categoryRepository;
        $this->trackManager = $trackManager;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->model->with('parentCategory')->latest()->get();

        return view('admin.modules.category.index', compact('categories'));
    }

    public function show($id)
    {
        dd($id);
    }

    public function create()
    {
        $categories = [''=>'Choose parent category']+$this->categoryRepository->model->parentCategories()
            ->lists('name_en', 'id')->toArray();
        $categoryTypes= ['blog'=>'Blog','track'=>'Track'];
        return view('admin.modules.category.create',compact('categories','categoryTypes'));
    }

    /**
     * @param Request $request
     * @param PhotoRepository $photoRepository
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, PhotoRepository $photoRepository)
    {
        $this->validate($request, [
            'name_en' => 'required|unique:categories,name_en',
            'cover'   => 'image',
            'parent_id' => 'numeric',
        ]);

        $category = $this->categoryRepository->model->fill(array_merge($request->all(),
            ['slug' => $request->name_en]));

        //create a folder
        $this->trackManager->createCategoryDirectory($category->slug);

        $category->save();

        // upload photos
        if ($request->hasFile('cover')) {

            $photoRepository->attach($request->file('cover'), $category, ['thumbnail' => 1]);
        }

        return redirect('/admin/category')->with('message', 'success');
    }

    public function edit($id)
    {
        $categoryTypes= ['blog'=>'Blog','track'=>'Track'];

        $categories = [''=>'Choose parent category']+$this->categoryRepository->model->parentCategories()
                ->lists('name_en', 'id')->toArray();

        $category = $this->categoryRepository->model->find($id);


        return view('admin.modules.category.edit', compact('category','categories','categoryTypes'));
    }

    public function update(Request $request, PhotoRepository $photoRepository, $id)
    {
        $this->validate($request, [
            'name_en' => 'required|unique:categories,name_en,' . $id,
            'cover'   => 'image'
        ]);

        $category = $this->categoryRepository->model->find($id);

        $oldSlug = $category->slug;

        $category->fill(array_merge($request->all(),
            ['slug' => $request->name_en]));

        if ($category->isDirty('name_en')) {
            $this->trackManager->updateCategoryDirectory($oldSlug, $category->slug);
        }

        if ($request->hasFile('cover')) {
            $photoRepository->replace($request->file('cover'), $category, ['thumbnail' => 1], $id);
        }

        $category->save();

        return redirect('admin/category')->with('message', 'success');

    }

    public function destroy($id)
    {
        $category = $this->categoryRepository->model->find($id);
        $category->delete();

        return redirect()->back()->with('success', 'Record Deleted');
    }
}
