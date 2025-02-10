#include <WiFi.h>
#include <WebServer.h>

const char* ssid = "Arduino";
const char* password = "Tech solutions";

const int lampPin = 26; // Pino onde a lâmpada está conectada
WebServer server(8080);

// Definição do IP fixo
IPAddress local_IP(192, 168, 1, 7);
IPAddress gateway(192, 168, 1, 1);
IPAddress subnet(255, 255, 255, 0);

void handleLigar() {
    digitalWrite(lampPin, HIGH);
    server.send(200, "text/plain", "Lampada Ligada");
}

void handleDesligar() {
    digitalWrite(lampPin, LOW);
    server.send(200, "text/plain", "Lampada Desligada");
}

void setup() {
    Serial.begin(9600);
    
   
    WiFi.begin(ssid, password);
    Serial.print("WiFi...");
    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }
     if (!WiFi.config(local_IP, gateway, subnet)) {
        Serial.println("IP Fail");
    }
    Serial.println("\nOK");
    Serial.print("IP: ");
    Serial.println(WiFi.localIP());
    Serial.print("MAC: ");
    Serial.println(WiFi.macAddress());
    
    pinMode(lampPin, OUTPUT);
    digitalWrite(lampPin, LOW);
    
    server.on("/LIGAR", handleLigar);
    server.on("/DESLIGAR", handleDesligar);
    server.begin();
    Serial.println("HTTP OK");
}

void loop() {
    server.handleClient();
}
