import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Message} from "../entities/Message.model";

@Injectable()
export class BackendService {
  
  constructor(private httpClient:HttpClient){
    
  }
  
  public getMessages() {
    return this.httpClient.get<Array<Message>>("/messages");
  }
  
  public sendMessage(message: Message){
    this.httpClient.post("/messages", message).subscribe();
  }
  
}
