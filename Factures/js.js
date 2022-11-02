var bill = {

  items : {
    "Patates" : 1.1, "Pomes" : 2.2, "Cireres" : 3.3,
    "Pinyes" : 2.3, "Maduixes" : 1.2, "Figues" : 2.1
  },


  init : () => {

    let list = document.getElementById("afegirItems");
    for (let [k,v] of Object.entries(bill.items)) {
      let opt = document.createElement("option");
      opt.innerHTML = k;
      list.appendChild(opt);
    }

    let item = document.getElementById("afegirItem"),
        Preu = document.getElementById("afegirPreu");
    item.onchange = () => { if (bill.items[item.value]) {
      Preu.value = bill.items[item.value];
    }};

    document.getElementById("imprimir").onclick = bill.print;
    document.getElementById("form").onsubmit = bill.add;
  },

  add : () => {

    let hItems = document.getElementById("items"),
        hQty = document.getElementById("afegirQuantitat"),
        hItem = document.getElementById("afegirItem"),
        hPreu = document.getElementById("afegirPreu");

    let row = document.createElement("div");
    row.className = "row";

    let col = document.createElement("div");
    col.className = "qty";
    col.innerHTML = hQty.value;
    row.appendChild(col);

    col = document.createElement("div");
    col.className = "name";
    col.innerHTML = hItem.value;
    row.appendChild(col);

    col = document.createElement("div");
    col.className = "Preu";
    col.innerHTML = (+hQty.value * parseFloat(hPreu.value)).toFixed(2);
    row.appendChild(col);

    col = document.createElement("button");
    col.innerHTML = "<span class='mi'>Borrar</span>";
    col.onclick = () => { bill.del(row); };
    row.appendChild(col);
    hItems.appendChild(row);

    hQty.value = 1;
    hItem.value = "";
    hPreu.value = "0.00";
    bill.total();
    return false;
  },

  del : (row) => {
    row.remove();
    bill.total();
  },

  total : () => {
    let all = document.querySelectorAll("#items .Preu"),
        amt = 0;
    if (all.length>0) { for (let p of all) {
      amt += parseFloat(p.innerHTML);
    }}
    document.getElementById("totalB").innerHTML = amt.toFixed(2);
  },

  print : () => {

    let all = document.querySelectorAll("#items .row");

    if (all.length>0) {
      let pwin = window.open("factura.html");
      pwin.onload = () => {


            for (let i of all) {
          let clone = i.cloneNode(true);
          clone.getElementsByTagName("button")[0].remove();
          list.appendChild(clone);
        }

        let total = pdoc.createElement("div");
        total.className = "total";
        total.innerHTML = "TOTAL: " + document.getElementById("totalB").innerHTML;
        list.appendChild(total);

        pwin.print();
      };
    } else { alert("No hi han productes a la factura"); }
  }
};
window.addEventListener("load", bill.init);
