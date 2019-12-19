<?php


namespace App\Controller;


use App\Repository\AgenteRepository;
use App\Repository\DelegacionRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class DelegacionGlobalFilterAction
{
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var DelegacionRepository
     */
    private $delegacionRepository;
    
    
    public function __construct(DelegacionRepository $delegacionRepository,
                                LoggerInterface $logger)
    {
        $this->logger = $logger;
    
        $this->delegacionRepository = $delegacionRepository;
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
        
        $this->logger->info("Busqueda global de Delegacion ".$termino);
        
        $objects = $this->delegacionRepository->findByTermino($termino,$page, $size, $order);
        $this->logger->info("Cantidad de Delegacion encontrados ".count($objects));
        return $objects;
    }
}