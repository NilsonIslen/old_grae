<?php

                        echo "<form action='index.php' method='POST'>";
                        echo "<input type='hidden' name='usuario' value='$UsuarioS'>";
                        echo "<input type='hidden' name='clave' value='$ClaveS'>";
                        echo "<input type='hidden' name='IdCli' Value='$IdCli'>";
                        echo "<input type='hidden' name='id_us' Value='$id_us'>";
                        echo "<input type='hidden' name='Vendedor' Value='$name_us'>";
                        echo "<input type='hidden' name='Cliente' Value='$NameCli'>";
                        echo "<input type='hidden' name='Barrio' Value='$Barrio'>";
                        echo "<input type='number' min='0' max='$OAM400g5' name='AM400g5' placeholder='AM400g5'>";
                        echo "<input type='number' min='0' max='$OAM550g5' name='AM550g5' placeholder='AM550g5'>";
                        echo "<input type='number' min='0' max='$OAM800g20' name='AM800g20' placeholder='AM800g20'>";
                        echo "<input type='number' min='0' max='$o_masax1k' name='masax1k' placeholder='Masax1K'>";
                        echo "<button type='submit' name='venta'> Enviar </button>";
                        echo "</form>";

?>