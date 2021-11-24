<form action='index.php' method='POST'>
        <?php
           echo "<input type='hidden' name='NumAl' Value='$Al'>";
        ?>
        <input type='text' name='Cliente' placeholder='Nombre del cliente o negocio' required>
                 
        <?php
         include "arrays/neighborhoods.php";
         echo "<p> Barrio:";
         echo "<select name='Barrio'>";
         $Br = 1;
         while($Br <= $cant_neighb){
            $Barr = $Br++; 
            $Barrios = $Barrs[$Barr]; 
           echo "<option value='$Barrios'> $Barrios </option>";
         }
         echo "</select> </p> ";
        ?>

                 <input type='text' name='Direccion' placeholder='Direccion'required>
                 <input type='text' name='Telefono' placeholder='Telefono'required>
                 <?php echo "<select id='Sel$NumColor' name='Color'>"; ?>
                 <option value=0> De que color es esta casilla? </option>
                 <option value=1> Amarillo </option>
                 <option value=2> Azul </option>
                 <option value=3> Rojo </option>
                 <option value=4> Verde </option>
                 </select>

                 <button type='submit' name='nuevoCliente'> Registrar nuevo cliente </button>
        </form>
