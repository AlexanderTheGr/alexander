<?php

namespace EavBundle\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\UnitOfWork;
use EavBundle\Entity\EavAttribute;
use EavBundle\Entity\EavEntity;

class EavAttributeCreatorListener
{
    private $entities = null;

    private $cacheDir;

    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        
        echo "s";
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        $entity = $eventArgs->getEntity();
        $classname = get_class($entity);

        if (!array_key_exists($classname, $this->getEntities())) {
            return null;
        }

        /** @var EavEntity $eavEntity */
        $eavEntity = $em->getRepository('EavEntity:EavEntity')->findOneBy([
            'entity' => $classname,
        ]);

        if ($eavEntity === null) {
            throw new \UnexpectedValueException('EavEntity not found for ' . $classname);
        }

        $qb = $em->getRepository($classname)->createQueryBuilder('main');

        $qb
            ->distinct()
            ->select('d.id')
            ->join('main.attributes', 'a')
            ->join('a.definition', 'd', null, null, 'd.id')
            ->where('main = :main')
            ->setParameter('main', $entity)
        ;

        $definitions = $qb->getQuery()->getArrayResult();

        foreach ($eavEntity->getDefinitions() as $definition) {
            if (!array_key_exists($definition->getId(), $definitions)) {
                $attribute = new EavAttribute();
                $attribute->setDefinition($definition);

                $entity->addEavAttribute($attribute);
            }
        }

        if ($uow->getEntityState($entity) == UnitOfWork::STATE_MANAGED) {
            $em->persist($entity);
            $em->flush($entity);
        }
    }

    /**
     * @return array
     */
    protected function getEntities()
    {
        if ($this->entities === null) {
            $this->entities = include $this->cacheDir . '/eav_bundle/Entity.cache.php';
        }

        return $this->entities;
    }
}
