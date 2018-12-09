<?php
/**
 * Created by IntelliJ IDEA.
 * User: adumitrescu
 * Date: 09.12.2018
 * Time: 22:44
 */

namespace App\Controller;


use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MessageController extends AbstractController
{
    private $messageRepository;
    private $serializer;
    private $entityManager;
    private $rabbitmqProducer;

    /**
     * MessageController constructor.
     * @param MessageRepository $messageRepository
     * @param EntityManagerInterface $entityManager
     * @param ProducerInterface $producer
     */
    public function __construct(MessageRepository $messageRepository, EntityManagerInterface $entityManager, ProducerInterface $producer)
    {
        $this->messageRepository = $messageRepository;
        $this->entityManager = $entityManager;
        $this->rabbitmqProducer = $producer;
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new DateTimeNormalizer(), new ObjectNormalizer());

        $this->serializer = new Serializer($normalizers, $encoders);
    }


    /**
     * @Route("/messages", methods={"GET"})
     * @return JsonResponse
     */
    public function getMessageAction()
    {
        $messages = $this->serializer->normalize($this->messageRepository->findAll());
        return new JsonResponse($messages);
    }

    /**
     * @Route("/messages",methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function addMessage(Request $request)
    {
        $body = $request->getContent();
        if (isset($body['id'])){
            unset($body['id']);
        }
        /** @var Message $entity */
        $entity = $this->serializer->deserialize($body, Message::class, "json");
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        $normalizedEntity = $this->serializer->normalize($entity, "json");
        $this->rabbitmqProducer->publish(json_encode($normalizedEntity, JSON_FORCE_OBJECT));
        return new Response("",Response::HTTP_CREATED);
    }
}