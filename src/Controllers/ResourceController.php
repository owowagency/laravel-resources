<?php

namespace owowagency\LaravelResources\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use owowagency\LaravelResources\Requests\ResourceRequest;

class ResourceController extends Controller
{
    /**
     * The resource model class.
     *
     * @var string
     */
    public $resourceModelClass;

    /**
     * The resource manager.
     *
     * @var \App\Managers\ResourceManager
     */
    public $resourceManager;

    /**
     * ResourceController constructor.
     *
     * @return void
     * 
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setResourceModelClass();

        $this->setResourceManager();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', $this->resourceModelClass);

        $resourcesPaginated = $this->resourceManager->paginate();

        $resources = resource($resourcesPaginated, true);

        $resourcesPaginated->setCollection($resources->collection);

        return ok($resourcesPaginated);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $this->validateRequest();

        $this->authorize('create', [$this->resourceModelClass, $request->validated()]);

        $resource = $this->resourceManager->create($request->validated());

        $resource = resource($resource);

        return created($resource);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', [$this->resourceModelClass, $id]);

        $resource = $this->resourceManager->find($id);

        $resource = resource($resource);

        return ok($resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request = $this->validateRequest();

        $this->authorize('update', [$this->resourceModelClass, $id, $request->validated()]);

        $resource = $this->resourceManager->update($request->validated(), $id);

        $resource = resource($resource);

        return ok($resource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', [$this->resourceModelClass, $id]);

        $this->resourceManager->delete($id);

        return no_content();
    }

    /**
     * Sets the resource model class.
     * When no request is present, like in terminal, skip.
     * Throw exception route has no specified model.
     * 
     * @throws \Exception
     *
     * @return void
     */
    public function setResourceModelClass()
    {
        $request = request();

        if (! $request || ! $request->route()) {
            return;
        }

        $resourceModelClass = $request->route()->getAction('model');

        if (is_null($resourceModelClass)) {
            throw new \Exception('Route has no specified model.');
        }

        $this->resourceModelClass = $resourceModelClass;
    }

    /**
     * Sets resource manager.
     * Do not set when no resource model class is set.
     * 
     * @return void
     */
    public function setResourceManager()
    {
        if (! $this->resourceModelClass) {
            return;
        }

        $this->resourceManager = manager($this->resourceModelClass);
    }

    /**
     * Validates request by classes specified in the route.
     * 
     * @return \Illuminate\Foundation\Http\FormRequest
     */
    public function validateRequest() : FormRequest
    {
        $requests = request()->route()->getAction('requests');

        if (is_null($requests)) {
            return app(ResourceRequest::class);
        }

        $actionMethod = request()->route()->getActionMethod();

        if (! array_key_exists($actionMethod, $requests)) {
            return app(ResourceRequest::class);
        }

        $requestClass = $requests[$actionMethod];

        return app($requestClass);
    }
}
