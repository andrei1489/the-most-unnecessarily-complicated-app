import {Component} from '@angular/core';
import {WebsocketService} from "./services/websocket.service";
import {Message} from "./entities/Message.model";
import {BackendService} from "./services/backend.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  messages: Array<Message> = [];
  newMessage: Message = new Message(null,null,null);

  constructor(private websocketService: WebsocketService, private backendService: BackendService) {
    this.backendService.getMessages().subscribe(response => {
      this.messages = response;
    });
    
    websocketService.getMessageStream().subscribe(value => {
      this.messages.push(value);
      console.log(value);
    });
  }

  sendMessage() {
    this.backendService.sendMessage(this.newMessage);
    this.newMessage.message = "";
  }
}
