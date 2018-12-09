export class Message {
  id:number;
  message:String;
  timestamp: Date;


  constructor(id: number, message: String, timestamp: Date) {
    this.id = id;
    this.message = message;
    this.timestamp = timestamp;
  }

}
