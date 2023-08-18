<?php

namespace OwowAgency\LaravelResources\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use OwowAgency\LaravelResources\Requests\ResourceRequest;

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

        $resources = resource($models);

        return ok($resources);
    }

    /**
     * Returns models instances used for the index action.
     */
    public function indexModel()
    {
        return $this->resourceModelClass::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', [$this->resourceModelClass, $request->all()]);

        $request = $this->validateRequest();

        $model = $this->storeModel($request);

        $resource = resource($model);

        return created($resource);
    }

    /**
     * Stores and returns the model instance for the store action.
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
     */
    public function showModel(Model $model)
    {
        return $model;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $model)
    {
        $model = $this->getModel($model);

        $this->authorize('update', [$model, $request->all()]);

        $request = $this->validateRequest();

        $this->updateModel($request, $model);

        $resource = resource($model);

        return ok($resource);
    }

    /**
     * Updates and returns the model instance for the update action.
     *
     * @return void
     */
    public function updateModel(Request $request, Model $model)
    {
        $model->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
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
     * Authorize a given action for the current user.
     *
     * @param  array|mixed  $arguments
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
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getModel($value): Model
    {
        if ($value instanceof Model) {
            return $value;
        }

        $instance = new $this->resourceModelClass;

        $model = $instance->resolveRouteBinding($value);

        if (is_null($model)) {
            throw (new ModelNotFoundException)->setModel(
                $this->resourceModelClass,
                $value,
            );
        }

        return $model;
    }
}
