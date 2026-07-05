import java.io.*;
import java.net.*;
import java.nio.charset.StandardCharsets;
public class SoapClient {
    private final String url;
    public SoapClient(String url) { this.url = url; }
        public String appeler(String methode, String... parametres) throws IOException {
        StringBuilder args = new StringBuilder();
                for (int i = 0; i < parametres.length; i++) {
                args.append("<p").append(i).append(">")
                .append(escape(parametres[i]))
                .append("</p").append(i).append(">");
                }
        String enveloppe =
        "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" +
        "<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">" +
        "<soap:Body><" + methode + ">" + args + "</" + methode + "></soap:Body>" +
        "</soap:Envelope>";
        HttpURLConnection cx = (HttpURLConnection) new URL(url).openConnection();
        cx.setRequestMethod("POST");
        cx.setDoOutput(true);
        cx.setRequestProperty("Content-Type", "text/xml;charset=utf-8");
        cx.setRequestProperty("SOAPAction", methode);
            try (OutputStream os = cx.getOutputStream()) {
            os.write(enveloppe.getBytes(StandardCharsets.UTF_8));
            }
        try (BufferedReader br = new BufferedReader(
        new InputStreamReader(cx.getInputStream(), StandardCharsets.UTF_8))) {
        StringBuilder reponse = new StringBuilder();
        String ligne;
        while ((ligne = br.readLine()) != null) reponse.append(ligne);
        return reponse.toString();
        }
        }
        public static String extraireValeur(String xml, String balise) {
        int debut = xml.indexOf("<" + balise);
        int finOuverture = xml.indexOf(">", debut) + 1;
        int fin = xml.indexOf("</" + balise, finOuverture);
        if (debut == -1 || fin == -1) return "";
        return xml.substring(finOuverture, fin);
        }
        private static String escape(String s) {
        return s.replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;");
        }
    }