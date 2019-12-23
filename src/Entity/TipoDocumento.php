<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\TipoDocumentoGlobalFilterAction;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TipoDocumento
 *@ApiFilter(
 *     OrderFilter::class,
 *     properties={
 *              "id",
 *              "tipo"
 *     },
 *     arguments={"orderParameterName"="_order"}
 * )
 * @ApiFilter(
 *     RangeFilter::class,
 *     properties={
 *              "id"
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"enabled"})
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *           "id": "exact",
 *          "tipo":"partial"
 *     }
 * )
 * @ApiResource(
 *     attributes={"order"={"id" : "DESC" },
 *                 "pagination_enabled"=true,
 *                 "pagination_client_enabled"=true,
 *                  "pagination_client_items_per_page"=true,
 *                  "maximum_items_per_page"=30
 *      },
 *      itemOperations={
 *              "get"={
 *                      "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *                       "normalization_context"={
 *                            "groups" = { "get" }
 *                      }
 *               },
 *              "put"={
 *                      "access_control"="is_granted('ROLE_ADMIN')",
 *                      "denormalization_context"={
 *                            "groups" = { "put" }
 *                      },
 *                   "normalization_context"={
 *                            "groups" = { "get" }
 *                      }
 *              }
 *     },
 *      collectionOperations={
 *
 *              "get-global-search"={
 *                      "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *                      "method"="GET",
 *                      "path"="/tipo-documentos/globalFilter",
 *                      "controller"=TipoDocumentoGlobalFilterAction::class,
 *                      "defaults"={"_api_receive"=false}
 *               },
 *              "get"={
 *                      "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *                       "normalization_context"={
 *                            "groups" = { "get" }
 *                      }
 *               },
 *              "post" = {
 *                      "access_control"="is_granted('ROLE_ADMIN')",
 *                       "denormalization_context"={
 *                            "groups" = { "post" }
 *                      },
 *                      "normalization_context"={
 *                            "groups" = { "get" }
 *                      }
 *
 *
 *                  }
 *      }
 *
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TipoDocumentoRepository")
 * @ORM\Table(name="tipo_documento")
 * @ORM\HasLifecycleCallbacks()
 */
class TipoDocumento
{
    /**
     * @Groups({"get"})
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /*============================Variables ===============================*/

    /**
     *@var string
     * @Groups({"get", "post", "put"})
     * @ORM\Column(name="tipo", type="string", length=10)
     * @Assert\NotBlank()
     * @Assert\Length(min = 1)
     * @Assert\Length( max = 10 )
     * @Assert\NotNull()
     */
    private $tipo;
    
    
    /**
     * @var \DateTime|null
     * @Groups({"get"})
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;
    
    /**
     * @var \DateTime|null
     * @Groups({"get"})
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;
    
    /**
     * @var \DateTime|null
     * @Groups({"get", "post", "put"})
     * @ORM\Column(name="fecha_baja", type="datetime", nullable=true)
     */
    private $fechaBaja;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }
    
    /*============================Setter y getters ===============================
     *
     */
    /**
     * Set tipo
     *
     * @param string $tipo
     * @return TipoDocumento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /*============================Constructor   ===============================
     */

    public function __toString() {
        return $this->getTipo();

    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     * @return TipoDocumento
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime 
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }
    
    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }
    
    /**
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
    
    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    
    
}
