<?php

namespace OwowAgency\LaravelResources\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Bus\DispatchesJobs;
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
     *
     * @return void
     * 
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setResourceModelClass();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', $this->resourceModelClass);

        $paginated = $this->resourceModelClass::paginate();

        $resources = resource($paginated, true);

        $paginated->setCollection($resources->collection);

        return ok($paginated);
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

        $model = $this->resourceModelClass::create($request->validated());

        $resource = resource($model);

        return created($resource);
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $model
     * @return \Illuminate\Http\Response
     */
    public function show($model)
    {
        $model = $this->getModel($model);

        $this->authorize('view', $model);

        $resource = resource($model);

        return ok($resource);
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

        $model->update($request->validated());

        $resource = resource($model);

        return ok($resource);
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

        $model->delete();

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

    /**
     * Tries to retrieve the model.
     * 
     * @param  mixed  $model
     * @return int
     */
    public function getModel($model)
    {
        if ($model instanceof Model) {
            return $model;
        }

        return $this->resourceModelClass::findOrFail($model);
    }
}
