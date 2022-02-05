# index.php
**Funktion:** Das ist die Registrierungsseite von ranzig.at - Hier werden neue Accounts erstellt. <br>
**Benötigt für:**  - <br>
**Besonderheiten:** Wenn kein Token in der Url gesetzt ist, dann wird man auf die Login-Seite weitergeleitet. Dadurch, dass sich diese index.php selbst aufruft, wurde in der Datenbank ein Token festgelegt, der für immer gültig ist. DIESER IST NUR FÜR INTERNE ZWECKE ZU GEBRAUCHEN. <br>
<br>
In Zukunft könnte man einen Zufallsgenerator für die url im <form>-Tag schreiben, der diesen zufällig generierten Token in die Datenbank schreibt und dieser dann überprüft wird. So würde man verhindern, dass ein Token für immer existiert.

# getEmails.php
**Funktion:** Checkt, ob es in der Datenbank eine E-Mail gibt, wie die, die übergeben wurde. <br>
**Benötigt für:** Wird von der index.php aufgerufen, um zu checken, ob die eingegebene E-Mail bereits verwendet wird. <br>
**Besonderheiten:** -

# getUsernames.php
**Funktion:** Checkt, ob es in der Datenbank einen Usernamen gibt, wie der, der übergeben wurde. <br>
**Benötigt für:** Wird von der index.php aufgerufen, um zu checken, ob der eingegebene Username bereits verwendet wird. <br>
**Besonderheiten:** -
