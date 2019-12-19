<?php


namespace App\Controller;


use App\Repository\TipoDocumentoRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class TipoDocumentoGlobalFilterAction
{
   
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var TipoDocumentoRepository
     */
    private $tipoDocumentoRepository;
    
    
    public function __construct(TipoDocumentoRepository $tipoDocumentoRepository,
                                LoggerInterface $logger)
    {
        $this->logger = $logger;
    
        $this->tipoDocumentoRepository = $tipoDocumentoRepository;
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
        
        $this->logger->info("Busqueda global de Tipos De Documentos ".$termino);
        
        $objects = $this->tipoDocumentoRepository->findByTermino($termino,$page, $size, $order);
        $this->logger->info("Cantidad de Tipos De Documentos encontrados ".count($objects));
        return $objects;
    }
}