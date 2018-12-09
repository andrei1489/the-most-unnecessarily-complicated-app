import {Injectable} from "@angular/core";
import {Message} from "../entities/Message.model";
import {Subject} from "rxjs";
import * as socketIo from 'socket.io-client';

//TODO change this to host
const SERVER_URL = 'http://192.168.150.11:8080';

@Injectable()
export class WebsocketService{
  private messages$: Subject<Message> = new Subject<Message>();
  private socket:any;

  constructor() {
    this.socket = socketIo(SERVER_URL);
    this.socket.on('message', (data: any) => {
      console.log("got message:"+data);
      const message = JSON.parse(data);
      message.timestamp = new Date(message.timestamp);
      this.messages$.next(message);
    });
  }
  
  public getMessageStream(){
    return this.messages$.asObservable();
  }
}
