# index.php
**Funktion:** Das ist die Registrierungsseite von ranzig.at - Hier werden neue Accounts erstellt. <br>
**Benötigt für:**  - <br>
**Besonderheiten:** 
- Wenn kein Token in der Url gesetzt ist, dann wird man auf die Login-Seite weitergeleitet. Dadurch, dass sich diese index.php selbst aufruft, wird (wenn der 'r'-Parameter in der Url NICHT gesetzt ist) ein neuer Token erstellt, und in die Datenbank geschrieben. Dieser wird dann in der Url beim selbstaufruf wieder übergeben und danach aus der Datenbank gelöscht. -> Der selbstaufruf findet statt, um die Register-Daten in die Datenbank zu schreiben und die userId in der Session zu setzen.
- Bei der Validierung der Benutzereingaben wurde viel Javascript verwendet. Dieser Code könnte verwirrend sein.

# getEmails.php
**Funktion:** Checkt, ob es in der Datenbank eine E-Mail gibt, wie die, die übergeben wurde. <br>
**Benötigt für:** Wird von der index.php aufgerufen, um zu checken, ob die eingegebene E-Mail bereits verwendet wird. <br>
**Besonderheiten:** -

# getUsernames.php
**Funktion:** Checkt, ob es in der Datenbank einen Usernamen gibt, wie der, der übergeben wurde. <br>
**Benötigt für:** Wird von der index.php aufgerufen, um zu checken, ob der eingegebene Username bereits verwendet wird. <br>
**Besonderheiten:** -
