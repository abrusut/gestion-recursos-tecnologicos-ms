<?php


namespace App\Controller;


use App\Repository\TipoDocumentoRepository;
use App\Repository\TipoRecursoRepository;
use App\Repository\UbicacionRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class UbicacionGlobalFilterAction
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var TipoDocumentoRepository
     */
    private $tipoDocumentoRepository;
   
    /**
     * @var UbicacionRepository
     */
    private $ubicacionRepository;
    
    
    public function __construct(UbicacionRepository $ubicacionRepository,
                                LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->ubicacionRepository = $ubicacionRepository;
    }
    
    public function __invoke(Request $request)
    {
        $termino = $request->get('termino');
        
        $size =  $request->get('size');
        $size = isset($size) && $size ? $size : 20;
        
        $page = $request->get('page');
        $page = isset($page) && $page ? $page : 1;
        
        $order = $request->get('_order');
        $order = isset($order) && $order ? $order : array('id'=>'desc');
        
        $this->logger->info("Busqueda global de Ubicacion ".$termino);
        
        $objects = $this->ubicacionRepository->findByTermino($termino,$page, $size, $order);
        $this->logger->info("Cantidad de Ubicacion encontrados ".count($objects));
        return $objects;
    }
}