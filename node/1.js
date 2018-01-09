 exports.select = function (cb){
    var lista = [];
    var db = new sqlite3.Database(file);           
    db.all("SELECT * FROM usuarios", function(err,rows){
         if(err) return cb(err);
         let contador = 0; 
         rows.forEach(function (row) { 
            lista[contador] = row.nombre + ";" + row.cedula + ";" + row.edad + ";"
    + row.pais; }); 
        db.close();
        return cb(null, lists);
}); 
 }