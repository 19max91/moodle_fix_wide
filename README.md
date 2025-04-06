# moodle_fix_wide


Η διαδικασία της επίλυσης των προβλημάτων ήταν η εξής:

Μετα την ενεργοποίηση του plugin, πήγα στο local/practice/index.php, και δοκιμασα να βάλω ενα record στη φόρμα.
Η φόρμα δε δούλεψε βγάζοντας μια απλή ειδοποίηση για error. 

Ενεργοποίησα το debugging από το Site Administration->Development->Debugging, βάζοντας το debugging messages σε "Developer".

Μετά από νέα δοκιμή της φορμάς, εμφανίστηκε αναλυτικά το λάθος, με την ειδοποίηση για "not null" στο timemodified. 
Για να διορθωθεί αυτό, έπρεπε να προσθέσω τη γραμμή $insertrecord->timemodified=time()-86400; πριν το insert_record (γραμμή 49 index.php)

Έπειτα από αυτό και τη πρσσθήκη της γραμμής, η φόρμα φάνηκε να περναει αλλά είχα "object not found error" αμέσως μετά το κλικ add record.
Παρατήρησα ότι ήταν λάθος η διεύθυνση, με τυπογραφικο λαθος στο redirection. Οπότε αλλάχθηκε η γραμμή redirect(new moodle_url('/local/practice/lndex.php')); σε
redirect(new moodle_url('/local/practice/index.php')); (γραμμή 51 index.php)

Αφού διορθώθηκε αυτο, είδα το records στο plugin αλλά οι εγγραφές είχαν προβλήματα.
  1.  Το επώνυμο ήταν ίδιο με το όνομα και
  2.  Δεν έβλεπα τις εγγραφές στο timecreated και καθόλου την στήλη timemodified
  

Για το πρόβλημα 1, με έλεγχο του κώδικα στα αρχεία του plugin, είδα οτι υπήρχε τα ακόλουθα λάθη: 
 a. $insertrecord->lastname=$fromform->firstname; στο index.php, οπότε αλλάχθηκε το σε $insertrecord->lastname=$fromform->lastname; (γραμμή 46 index.php)
 b. Πάρομοιως στο main.mustache είχαμε 2 φορές το fistname στο {{#data}} οπότε το 2ο αλλάχθηκε σε lastname  (γραμμή 15 main.mustache)

Για το πρόβλημα 2, έπρεπε να γίνουν τα ακόλουθα:
 a. προσθήκη της μεταβλητής $timemodified=date('d/m/Y H:i:s',$record->timemodified); μέσα στη foreach του main.php (γραμμη 56 main.php)
 b. προσθήκη των μεταβλητών 'timecreated'=>$timecreated και 'timemodified'=>$timemodified μέσα στο data array. (γραμμή 57 main.php)
 c. προσθήκη του header του πίνακα <th>Timemodified</th> και της γραμμής <td>{{timemodified}}</td> στο τέλος του {{#data}} main.mustache (γραμμές 8 και 18)

Αφού έγιναν οι διορθώσεις αυτές, η εμφάνιση των εγγραφών ήταν σωστή. 
Πρόβλημα ομώς φάνηκε τώρα με τις ημερομηνίες. Είμαι μια μέρα πίσω, άρα πρέπει στα 
  -$insertrecord->timemodified=time()-86400;
  -$insertrecord->timemodified=time()-86400;

  να αφαιρεσω το "-86400". (γραμμές 48 και 49 index.php)

  Επίσης προστέθηκε και ένα απλό validation στο index.php, στη γραμμή 39, επειδή η φόρμα επέτρεπε είσοδο κενών εγγραφών στην db. Ακολουθεί το κομμάτι κώδικα που πρσστέθηκε:


  if((($fromform->firstname)=="") or (($fromform->lastname)=="") or (($fromform->email)=="")){ 
        redirect(new moodle_url('/local/practice/index.php'));
  else{
    ...
        
    
  
