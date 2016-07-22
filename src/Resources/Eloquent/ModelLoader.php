<?php namespace Foothing\RepositoryController\Resources\Eloquent;

use Foothing\Request\AbstractRemoteQuery;
use Foothing\Resources\ResourceInterface;
use Foothing\Services\Resources\LoaderInterface;

class ModelLoader implements LoaderInterface {
	/**
	 * @var RemoteQuery
	 */
	protected $query;

	public function loadEntity( $resource, $id, $relations = array()) {
		$model = new $resource();

		// Override relations as requested.
		if ( ! empty($relations) ) {
			$relations = (array)$relations;
		}

		else if ($model instanceof ResourceInterface) {
			$relations = $model->unitRelations();
		}

		// Invoke Eloquent find and lazy load relations.
		$instance = call_user_func_array(array($resource, 'find'), array($id));
		$instance->load($relations);
		return $instance;
	}

	public function loadEntities( $resource, $page, $ipp, $relations = array() ) {
		$result = new $resource();

		// Override relations as requested.
		if ( ! empty($relations) ) {
			$relations = (array)$relations;
		}

		else if ($result instanceof ResourceInterface) {
			$relations = $result->listRelations();
		}

		if ( $this->query ) {
			if ( $this->query->sortEnabled ) {
				$result = $result->orderBy($this->query->sortField, $this->query->sortDirection);
			}

			if ($this->query->filterEnabled) {
				foreach ($this->query->filters as $filter) {
					if ($filter->operator == 'like') {
						$filter->value = "%{$filter->value}%";
					}
					$result = $result->where($filter->name, $filter->operator, $filter->value);
				}
			}

			$this->query = null;
		}

		return $result->with($relations)->paginate($ipp);
	}

	public function query(AbstractRemoteQuery $query) {
		$this->query = $query;
		return $this;
	}
}