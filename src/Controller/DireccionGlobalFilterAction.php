<?php


namespace App\Controller;


use App\Repository\AgenteRepository;
use App\Repository\DireccionRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class DireccionGlobalFilterAction
{
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var DireccionRepository
     */
    private $direccionRepository;
    
    
    public function __construct(DireccionRepository $direccionRepository,
                                LoggerInterface $logger)
    {
        $this->logger = $logger;
    
        $this->direccionRepository = $direccionRepository;
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
        
        $this->logger->info("Busqueda global de Direccion ".$termino);
        
        $objects = $this->direccionRepository->findByTermino($termino,$page, $size, $order);
        $this->logger->info("Cantidad de Direccion encontrados ".count($objects));
        return $objects;
    }
}