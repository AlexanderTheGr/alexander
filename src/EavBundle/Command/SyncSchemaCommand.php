<?php

namespace EavBundle\Command;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use EavBundle\Entity\EavEntity;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncSchemaCommand extends ContainerAwareCommand {

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
                ->setName('eav:schema:sync')
                ->setDescription('Syncs the existing schemas in the database with the current metadata')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $reader = new AnnotationReader();
        /** @var ManagerRegistry $doctrine */
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();
        $cmf = $em->getMetadataFactory();

        $existing = [];
        $created = [];

        /** @var ClassMetadata $metadata */
        foreach ($cmf->getAllMetadata() as $metadata) {
            $refl = $metadata->getReflectionClass();

            if ($refl === null) {
                $refl = new \ReflectionClass($metadata->getName());
            }

            //if ($reader->getClassAnnotation($refl, 'EavBundle\Annotation\Entity') != null) {
                $eavEntity = $em->getRepository('EavBundle:EavEntity')->findOneBy([
                    'entity' => $metadata->getName(),
                ]);

                if ($eavEntity === null) {
                    $eavEntity = new EavEntity();
                    $eavEntity->setEntity($metadata->getName());
                    $eavEntity->setCreated(new \DateTime('now'));
                    $eavEntity->setModified(new \DateTime('now'));
                    $em->persist($eavEntity);
                    $em->flush($eavEntity);

                    $created[] = $metadata->getName();
                } else {
                    $existing[] = $metadata->getName();
                }
            //}
        }

        $table = new Table($output);

        $table->addRow(['Created:', implode(PHP_EOL, $created)]);
        $table->addRow(new TableSeparator());
        $table->addRow(['Existing:', implode(PHP_EOL, $existing)]);

        $table->render();
    }

}
