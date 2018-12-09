package com.example.coursedemo;

import org.springframework.amqp.core.AmqpAdmin;
import org.springframework.amqp.core.Message;
import org.springframework.amqp.core.Queue;
import org.springframework.amqp.rabbit.annotation.RabbitListener;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import java.util.logging.Logger;

@Component
public class CourseListener {

    private static final Logger logger = Logger.getLogger( CourseListener.class.getName() );
    private RedisPublisher redisPublisher;

    @Autowired
    public CourseListener( AmqpAdmin rabbitAdmin, RedisPublisher publisher ) {
        rabbitAdmin.initialize();
        rabbitAdmin.declareQueue( new Queue( "messages" ) );
        this.redisPublisher = publisher;
    }

    @RabbitListener( queues = "messages" )
    public void processMessage( Message content ) {
        String message = new String( content.getBody() );
        logger.info( "Got message:" + message );
        redisPublisher.publishMessage( message );
        logger.info( "Published to redis" );

    }
}
