#include <NewPing.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <ESP8266WiFi.h>
#include <WiFiClientSecure.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFiMulti.h>

ESP8266WiFiMulti WiFiMulti;
LiquidCrystal_I2C lcd(0x27, 16, 2);

const char *ssid = "Anonymouse";          //Nama Wifi
const char *password = "modaldikitdong";  // pass wifi

#define LRED 14
#define LYEL 12
#define LGRE 13
#define hujan A0

#define TRIGGER_PIN 0                                // Arduino pin tied to trigger pin on the ultrasonic sensor.
#define ECHO_PIN 16                                  // Arduino pin tied to echo pin on the ultrasonic sensor.
#define MAX_DISTANCE 400                             // Maximum distance we want to ping for (in centimeters). Maximum sensor distance is rated at 400-500cm.
NewPing sonar(TRIGGER_PIN, ECHO_PIN, MAX_DISTANCE);  // NewPing setup of pins and maximum distance.

int suara = 14;
int cuaca = 1024;

WiFiClient client;
const int httpPort = 8000;
String url;
unsigned long timeout;

void setup() {
  lcd.init();
  lcd.backlight();
  Serial.begin(115200);  // Open serial monitor at 115200 baud to see ping results.
  pinMode(suara, OUTPUT);
  digitalWrite(suara, HIGH);
  pinMode(LED_BUILTIN, OUTPUT);
  pinMode(LRED, OUTPUT);
  pinMode(LYEL, OUTPUT);
  pinMode(LGRE, OUTPUT);
  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP(ssid, password);
  Serial.print("Connecting to WiFi..");
  while (WiFiMulti.run() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to ");
  lcd.print("Connected to ");
  Serial.println(ssid);
  lcd.print(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  lcd.clear();
}

void loop() {
  int jarak = 0;
  jarak = sonar.ping_cm();
  Serial.print("Jarak Air: ");
  Serial.print(jarak);
  Serial.println(" cm");

  lcd.setCursor(0, 0);
  lcd.print("Jarak = ");
  lcd.print(jarak);
  lcd.print(" cm ");
  lcd.setCursor(0, 1);
  lcd.print("Status = ");
  digitalWrite(LRED, jarak <= 20 ? LOW : HIGH);
  digitalWrite(LYEL, jarak > 20 && jarak <= 50 ? LOW : HIGH);
  digitalWrite(LGRE, jarak > 50 ? LOW : HIGH);
  Serial.print("Status=");
  Serial.println(jarak <= 20 ? "Banjir" : jarak <= 50 ? "Awas" : "Aman");
  lcd.setCursor(9, 1);
  lcd.print(jarak <= 20 ? "Bahaya  " : jarak <= 50 ? "Awas  " : "Aman  ");
  delay(100);

  int hujan = analogRead(hujan);
  Serial.print("Hujan : ");
  Serial.println(cuaca <= 500 ? " Ya " : " Tidak ");
  Serial.print("Value : ");
  Serial.println(hujan);
  delay(100);

  if ((WiFi.status() == WL_CONNECTED)) {
    WiFiClientSecure client;
    HTTPClient https;
    int id_alat = 1;
    String address;
    address ="http://192.168.100.42/SIG-Banjir/savedata.php?jarak=";
    address += String(jarak);
    address += "&hujan=";
    address += String(hujan);
    address += "&id_alat=";
    address += String(id_alat);
  
    https.begin(client,address);  //Specify request destination
    int httpCode = https.GET();//Send the request
    String payload;  
    if (httpCode > 0) { //Check the returning code    
        payload = https.getString();   //Get the request response payload
        payload.trim();
        if( payload.length() > 0 ){
           Serial.println(payload + "\n");
        }
    }
    
    https.end();   //Close connection
    } else{
    Serial.print("Not connected to wifi ");
    Serial.println(ssid);
    }
  delay(1000); //interval 60s
}
   
