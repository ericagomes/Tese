#include <uStepper.h>
#include "channels.h"
#include <math.h>

channels_t serial_channels;
uStepper stepper;

unsigned long currentMicros, previousMicros, interval;
bool button, varinic=HIGH;
int c_angle, turn=0, angle_Enc;
  
void serial_write(uint8_t b)
{
  Serial.write(b);
}

void process_serial_packet(char channel, uint32_t value, channels_t& obj)
{
 byte i;
 int32_t angle;

 if (channel == 's') {
  stepper.softStop(SOFT);
 
 }else if (channel == 'S') {
   stepper.softStop(HARD);
 
 } 
 else if (channel == 'm') {
   angle = value; 
   stepper.moveAngle(angle, HARD);

 } else if (channel == 't') {
   angle = value; 
   stepper.moveToAngle(angle, HARD);
     
 }else if (channel == 'v') {
   stepper.setMaxVelocity(value);
 
 } else if (channel == 'i') {
   interval = value;

 } else if (channel == 'g')  { // Ping
   obj.send(channel, value + 1);
   Serial.println(value + 1);
 }
}

void test(){
  if(varinic==HIGH){
    process_serial_packet('S', 0, serial_channels);
    process_serial_packet('m', -12, serial_channels); // 
    c_angle=0;
    varinic=LOW;
    Serial.println("houve interreupt");
  }
  else{
    c_angle=0;
    turn=turn+1;
    }
  }


void setup() 
{
  // put your setup code here, to run once:
  stepper.setup();
  stepper.setMaxAcceleration(500);
  stepper.setMaxVelocity(750);

  interval = 50000UL;
  
  Serial.begin(115200);
  serial_channels.init(process_serial_packet, serial_write);
  Serial.println("Init ustepper");
  pinMode(2, INPUT); 
  digitalWrite(2,HIGH);
  attachInterrupt(digitalPinToInterrupt(2), test, HIGH);
  process_serial_packet('m',180, serial_channels);
  
}


void loop() 
{
  byte i, b;
 
  button=digitalRead(2);  

  // Check serial port and process received byte
  if (Serial.available()) 
    {
      b = Serial.read();
            serial_channels.StateMachine(b);    
    }

 currentMicros = micros();

  // THE sensor Loop
  if (currentMicros - previousMicros >= interval) {
    previousMicros = currentMicros;
 
    serial_channels.send('t', stepper.temp.getTemp());
    Serial.println();
    angle_Enc=stepper.encoder.getAngle();
    Serial.println(angle_Enc);
    serial_channels.send('T', angle_Enc);
    Serial.println();
    Serial.println(button);
     Serial.println();
    Serial.println(c_angle);
    
Serial.println(turn);  }
}

// m00000080
// mFFFFFF80
