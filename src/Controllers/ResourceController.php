<?php

namespace OwowAgency\LaravelResources\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use OwowAgency\LaravelResources\Requests\ResourceRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ResourceController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests {
        AuthorizesRequests::authorize as traitAuthorize;
    }

    /**
     * The resource model class.
     *
     * @var string
     */
    public $resourceModelClass;

    /**
     * ResourceController constructor.
     */
    public function __construct()
    {
        $this->setResourceModelClass();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', $this->resourceModelClass);

        $models = $this->indexModel();

        $resources = resource($models, true);

        if ($models instanceof LengthAwarePaginator) {
            $models->setCollection($resources->collection);
        }

        return ok($models);
    }

    /**
     * Returns models instances used for the index action.
     * 
     * @return mixed
     */
    public function indexModel()
    {
        return $this->resourceModelClass::paginate();
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

        $model = $this->storeModel($request);

        $resource = resource($model);

        return created($resource);
    }

    /**
     * Stores and returns the model instance for the store action.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function storeModel(Request $request)
    {
        return $this->resourceModelClass::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Http\Response
     */
    public function show($model)
    {
        $model = $this->getModel($model);

        $this->authorize('view', $model);

        $model = $this->showModel($model);

        $resource = resource($model);

        return ok($resource);
    }

    /**
     * Returns the model instance for the show action.
     * 
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function showModel(Model $model)
    {
        return $model;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $model)
    {
        $request = $this->validateRequest();

        $model = $this->getModel($model);

        $this->authorize('update', [$model, $request->validated()]);

        $this->updateModel($request, $model);

        $resource = resource($model);

        return ok($resource);
    }

    /**
     * Updates and returns the model instance for the update action.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function updateModel(Request $request, Model $model)
    {
        $model->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($model)
    {
        $model = $this->getModel($model);

        $this->authorize('delete', $model);

        $this->destroyModel($model);

        return no_content();
    }

    /**
     * Deletes the model instance for the destroy action.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function destroyModel(Model $model)
    {
        $model->delete();
    }

    /**
     * Sets the resource model class.
     * When no request is present, like in terminal, skip.
     * Throw exception route has no specified model.
     * 
     * @return void
     * 
     * @throws \Exception
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
     * Authorize a given action for the current user.
     *
     * @param  mixed  $ability
     * @param  mixed|array  $arguments
     * @return mixed
     */
    public function authorize($ability, $arguments = [])
    {
        // Do not try to authorize when policy does not exist.
        if (is_null(Gate::getPolicyFor($this->resourceModelClass))) {
            return;
        }

        return $this->traitAuthorize($ability, $arguments);
    }

    /**
     * Validates request by classes specified in the route.
     * 
     * @return \Illuminate\Foundation\Http\FormRequest
     */
    public function validateRequest(): FormRequest
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

    /**
     * Tries to retrieve the model.
     * 
     * @param  mixed  $model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel($model): Model
    {
        if ($model instanceof Model) {
            return $model;
        }

        return $this->resourceModelClass::findOrFail($model);
    }
}
