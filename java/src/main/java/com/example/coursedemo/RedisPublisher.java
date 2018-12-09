package com.example.coursedemo;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.context.annotation.Bean;
import org.springframework.core.env.Environment;
import org.springframework.data.redis.connection.RedisConnectionFactory;
import org.springframework.data.redis.connection.jedis.JedisConnectionFactory;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.data.redis.core.StringRedisTemplate;
import org.springframework.stereotype.Component;

@Component
public class RedisPublisher {

    private RedisConnectionFactory factory;
    private String topic;

    @Autowired
    public RedisPublisher( RedisConnectionFactory factory, Environment env ) {
        this.factory = factory;
        this.topic = env.getProperty( "spring.redis.topic" );
    }

    @Bean
    public RedisTemplate<String, String> getRedisTemplate() {
        return new StringRedisTemplate( factory );
    }

    public void publishMessage( String message ) {
        RedisTemplate<String, String> template = getRedisTemplate();
        template.convertAndSend( topic, message );
    }

}
