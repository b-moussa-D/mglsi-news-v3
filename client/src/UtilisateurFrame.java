import javax.swing.*;
import java.awt.*;
public class UtilisateurFrame extends JFrame {
private final String jeton;
private final SoapClient client = new SoapClient(
"http://localhost/mglsi-news-v3/services/soap/soap_server.php");
private final DefaultListModel<String> modeleListe = new DefaultListModel<>();
public UtilisateurFrame(String jeton) {
super("Gestion des utilisateurs (administrateur)");
this.jeton = jeton;
setLayout(new BorderLayout());
JList<String> liste = new JList<>(modeleListe);
add(new JScrollPane(liste), BorderLayout.CENTER);
JButton rafraichir = new JButton("Rafraîchir la liste");
rafraichir.addActionListener(e-> chargerUtilisateurs());
add(rafraichir, BorderLayout.NORTH);
setDefaultCloseOperation(DISPOSE_ON_CLOSE);
setSize(420, 320);
setLocationRelativeTo(null);
chargerUtilisateurs();
}
private void chargerUtilisateurs() {
try {
String reponse = client.appeler("listerUtilisateurs", jeton);
modeleListe.clear();
modeleListe.addElement(reponse); // à raffiner avec un vrai parsing DOM si le temps le permet
} catch (Exception ex) {
JOptionPane.showMessageDialog(this, "Erreur:" + ex.getMessage());
}
}
}