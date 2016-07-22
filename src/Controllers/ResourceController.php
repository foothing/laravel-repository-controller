<?php namespace Foothing\RepositoryController\Controllers;

use Foothing\RepositoryController\Resources\LoaderInterface;
use Foothing\RepositoryController\Resources\Mapper;
use Foothing\RepositoryController\Resources\WriterInterface;
use Foothing\Request\Laravel\RemoteQuery;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ResourceController extends Controller {
	/**
	 * @var LoaderInterface
	 */
	protected $loader;

	/**
	 * @var WriterInterface
	 */
	protected $writer;

	/**
	 * @var Mapper
	 */
	protected $mapper;

	function __construct(LoaderInterface $loader, WriterInterface $writer, Mapper $mapper) {
		$this->loader = $loader;
		$this->writer = $writer;
		$this->mapper = $mapper;
	}

	/**
	 * /api/v1/resources/[resource]/{id?}/{relation?}?with=rel1,rel2&qparams={}
	 *
	 * @param Request $request
	 * @param string  $resource
	 * @param int     $id
	 * @param string  $args
	 *
	 * @return mixed
	 */
	public function getIndex(Request $request, $resource, $id = null, $args = null) {
		// Resource.
		$resource = $this->mapper->map($resource);

		if ($relations = $request->input('with')) {
			$relations = explode(",", $relations);
		}

		if ($id) {
			$result = $this->loader->loadEntity($resource, $id, $relations);

			// @TODO return child relation as resource.
			// We'll need the parent entity ID in order
			// to trigger repository access for child, i.e.
			// get:/resources/users/1/profile we need to
			// know which key bind profile to users.

			if ($args) {
				$args = explode("/", $args);
				return $result->{$args[0]};
			} else {
				return $result;
			}
		}

		else {
			$page = $request->get('page', 1);
			$ipp = $request->get('ipp', 50);

            // Apply criteria.
            $this->loader->query(RemoteQuery::spawn($request->input('qparams')));

            // Load.
            return $this->loader->loadEntities($resource, $page - 1, $ipp, $relations);
		}
	}

	public function putIndex(Request $request, $resource, $id) {
		$resource = $this->mapper->map($resource);
		return $this->writer->update($resource, $request->all(), $id);
	}

    public function putBulk(Request $request, $resource) {
        $resource = $this->mapper->map($resource);
        return $this->writer->bulkUpdate($resource, $request->all());
    }

	public function postIndex(Request $request, $resource) {
		$resource = $this->mapper->map($resource);
		return $this->writer->create($resource, $request->all());
	}

    public function postBulk(Request $request, $resource) {
        $resource = $this->mapper->map($resource);
        return $this->writer->bulkCreate($resource, $request->all());
    }

	public function deleteIndex(Request $request, $resource, $id) {
		$resource = $this->mapper->map($resource);
		return response()->json($this->writer->delete($resource, $id));
	}

}