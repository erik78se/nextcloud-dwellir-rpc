<?php
 namespace OCA\DRpc\Controller;

 use Exception;

 use OCP\IRequest;
 use OCP\AppFramework\Http;
 use OCP\AppFramework\Http\DataResponse;
 use OCP\AppFramework\Controller;

 use OCA\DRpc\Db\Rpc;
 use OCA\DRpc\Db\RpcMapper;

 class RpcController extends Controller {

     private RpcMapper $mapper;
     private ?string $userId;

     public function __construct(string $AppName, IRequest $request, RpcMapper $mapper, ?string $UserId = null){
         parent::__construct($AppName, $request);
         $this->mapper = $mapper;
         $this->userId = $UserId;
     }

     /**
      * @NoAdminRequired
      * @NoCSRFRequired
      */
     public function index(): DataResponse {
         return new DataResponse($this->mapper->findAll($this->userId));
     }

     /**
      * @NoAdminRequired
      *
      * @param int $id
      */
     public function show(int $id): DataResponse {
         try {
             return new DataResponse($this->mapper->find($id, $this->userId));
         } catch(Exception $e) {
             return new DataResponse([], Http::STATUS_NOT_FOUND);
         }
     }

     /**
      * @NoAdminRequired
      *
      * @param string $name
      * @param string $notes = null
      * @param string $wsuri = null
      * @param string $httpuri = null
      */
     public function create(string $name, string $notes = null, string $wsuri = null, string $httpuri = null): DataResponse {
         $rpc = new Rpc();
         $rpc->setUserId($this->userId);
         $rpc->setName($name);
         $rpc->setNotes($notes);
         $rpc->setWsuri($wsuri);
         $rpc->setHttpuri($httpuri);
         return new DataResponse($this->mapper->insert($rpc));
     }

     /**
      * @NoAdminRequired
      *
      * @param int $id
      * @param string $name
      * @param string $notes = null
      * @param string $wsuri = null
      * @param string $httpuri = null
      */
      public function update(string $name, string $notes = null, string $wsuri = null, string $httpuri = null): DataResponse {
         try {
             $rpc = $this->mapper->find($id, $this->userId);
         } catch(Exception $e) {
             return new DataResponse([], Http::STATUS_NOT_FOUND);
         }
         //If not null ...
         $rpc->setName($name);
         $rpc->setNotes($notes);
         $rpc->setWsuri($wsuri);
         $rpc->setHttpuri($httpuri);
         
         return new DataResponse($this->mapper->update($rpc));
     }

     /**
      * @NoAdminRequired
      *
      * @param int $id
      */
     public function destroy(int $id): DataResponse {
         try {
             $rpc = $this->mapper->find($id, $this->userId);
         } catch(Exception $e) {
             return new DataResponse([], Http::STATUS_NOT_FOUND);
         }
         $this->mapper->delete($rpc);
         return new DataResponse($rpc);
     }

 }