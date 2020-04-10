<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Helpers\Jsend;
use Illuminate\Http\Request;
use JSend\JSendResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $model_name;
    private $model_path = "App\Models";

    private function getModel()
    {
        if ($this->model_name) {
            return $this->model_name;
        }

        $model = get_class($this);
        $model = str_replace(
            "App\Http\Controllers",
            $this->model_path,
            $model
        );
        $model = str_replace(
            "Controller",
            "",
            $model
        );

        return $model;
    }

    public function jsonResponse($result) {
        if ($result && get_class($result) == $this->getModel()) {
            if ($result->error)
                return JSend::sendErrorInfo($result->error, 409);
            return Jsend::success($result);
        } else if ($result) {
            return Jsend::success($result);
        }
        return JSend::fail("Data Not found", 404);
    }

    public function index()
    {
        $result = ($this->getModel())::fetch();
        return $this->jsonResponse($result);
    }

    public function store(Request $request)
    {
        $result = ($this->getModel())::record($request);
        return $this->jsonResponse($result);
    }

    public function show($id)
    {
        $result = ($this->getModel())::fetchById($id);
        return $this->jsonResponse($result);
    }

    public function update(Request $request, $id)
    {
        $result = ($this->getModel())::record($request, $id);
        return $this->jsonResponse($result);
    }

    public function destroy($id)
    {
        $result = ($this->getModel())::removeById($id);
        if ($result) {
            return JSend::success("Delete success", 200);
        }
        return JSend::fail("Data Not found", 404);
    }
}
