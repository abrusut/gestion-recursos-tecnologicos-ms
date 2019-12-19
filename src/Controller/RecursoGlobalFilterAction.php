<?php


namespace App\Controller;


use App\Repository\RecursoRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class RecursoGlobalFilterAction
{
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var RecursoRepository
     */
    private $recursoRepository;
    
    
    public function __construct(RecursoRepository $recursoRepository,
                                LoggerInterface $logger)
    {
        $this->logger = $logger;
    
    
        $this->recursoRepository = $recursoRepository;
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
        
        $this->logger->info("Busqueda global de Recursos ".$termino);
        
        $objects = $this->recursoRepository->findByTermino($termino,$page, $size, $order);
        $this->logger->info("Cantidad de Recursos encontradas ".count($objects));
        return $objects;
    }
}