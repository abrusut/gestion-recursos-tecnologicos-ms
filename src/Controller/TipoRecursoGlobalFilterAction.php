<?php


namespace App\Controller;


use App\Repository\TipoDocumentoRepository;
use App\Repository\TipoRecursoRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class TipoRecursoGlobalFilterAction
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
     * @var TipoRecursoRepository
     */
    private $tipoRecursoRepository;
    
    
    public function __construct(TipoRecursoRepository $tipoRecursoRepository,
                                LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->tipoRecursoRepository = $tipoRecursoRepository;
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
        
        $this->logger->info("Busqueda global de Tipos De Recurso ".$termino);
        
        $objects = $this->tipoDocumentoRepository->findByTermino($termino,$page, $size, $order);
        $this->logger->info("Cantidad de Tipos De Recurso encontrados ".count($objects));
        return $objects;
    }
}