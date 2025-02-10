#include <WiFi.h>
#include <WebServer.h>

const char* ssid = "Blackartch";
const char* password = "LinuxMqtt";

WebServer server(8080);

const int lamp1 = 27;
const int lamp2 = 26;
const int lamp3 = 25;
const int lamp4 = 14;

void handleRoot() {
    server.send(200, "text/plain", "ESP32 Controle de Lâmpadas");
}

void toggleLamp() {
    if (server.hasArg("lamp")) {
        int lamp = server.arg("lamp").toInt();
        int pin;
        
        switch (lamp) {
            case 1: pin = lamp1; break;
            case 2: pin = lamp2; break;
            case 3: pin = lamp3; break;
            case 4: pin = lamp4; break;
            default: server.send(400, "text/plain", "Lâmpada inválida"); return;
        }
        
        digitalWrite(pin, !digitalRead(pin));
        server.send(200, "text/plain", "Lâmpada " + String(lamp) + " alterada");
    } else {
        server.send(400, "text/plain", "Parâmetro 'lamp' ausente");
    }
}

void setup() {
    Serial.begin(9600);
    WiFi.begin(ssid, password);
    
    while (WiFi.status() != WL_CONNECTED) {
        delay(1000);
        Serial.println("Conectando ao WiFi...");
    }
    
    Serial.println("Conectado!");
    Serial.print("IP: ");
    Serial.println(WiFi.localIP());
    
    pinMode(lamp1, OUTPUT);
    pinMode(lamp2, OUTPUT);
    pinMode(lamp3, OUTPUT);
    pinMode(lamp4, OUTPUT);
    
    server.on("/", handleRoot);
    server.on("/toggleLamp", toggleLamp);
    
    server.begin();
    Serial.println("Servidor HTTP iniciado");
}

void loop() {
    server.handleClient();
}
