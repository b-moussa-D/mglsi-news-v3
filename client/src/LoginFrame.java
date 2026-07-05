import javax.swing.*;
import java.awt.*;
public class LoginFrame extends JFrame {
private final JTextField champLogin = new JTextField(15);
private final JPasswordField champMotDePasse = new JPasswordField(15);
private final SoapClient client = new SoapClient(
"http://localhost/mglsi-news-v3/services/soap/soap_server.php");
public LoginFrame() {
super("MGLSI News-Connexion administrateur");
setLayout(new GridLayout(3, 2, 8, 8));
add(new JLabel("Login:")); add(champLogin);
add(new JLabel("Mot de passe:")); add(champMotDePasse);
JButton bouton = new JButton("Se connecter");
add(new JLabel()); add(bouton);
bouton.addActionListener(e-> connecter());
setDefaultCloseOperation(EXIT_ON_CLOSE);
setSize(320, 150);
setLocationRelativeTo(null);
}
private void connecter() {
try {
String reponse = client.appeler("authentifier",
champLogin.getText(), new String(champMotDePasse.getPassword()));
String jeton = SoapClient.extraireValeur(reponse, "return");
if (jeton == null || jeton.isEmpty()) {
JOptionPane.showMessageDialog(this, "Identifiants invalides.");
return;
}
new UtilisateurFrame(jeton).setVisible(true);
dispose();
} catch (Exception ex) {
JOptionPane.showMessageDialog(this, "Erreur de connexion au service:" + ex.getMessage());
}
}
public static void main(String[] args) {
SwingUtilities.invokeLater(()-> new LoginFrame().setVisible(true));
}
}