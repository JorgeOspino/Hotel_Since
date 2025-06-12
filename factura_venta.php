<?php

include('conexion.php');


$sql = "SELECT * FROM factura_venta";
$resultado = $conn->query($sql);


if ($resultado->num_rows > 0) {
   
    echo "<table border='1' style='width:100%; margin-top: 20px;'>";
    echo "<thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente Nombre</th>
                <th>Cliente Documento</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Valor Unitario</th>
                <th>Valor Total</th>
                <th>Recibí Conforme</th>
            </tr>
          </thead>
          <tbody>";

   
    while ($factura = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>" . $factura['id'] . "</td>
                <td>" . $factura['fecha'] . "</td>
                <td>" . $factura['cliente_nombre'] . "</td>
                <td>" . $factura['cliente_documento'] . "</td>
                <td>" . $factura['direccion_cliente'] . "</td>
                <td>" . $factura['telefono_cliente'] . "</td>
                <td>" . $factura['cantidad'] . "</td>
                <td>" . $factura['descripcion_producto'] . "</td>
                <td>" . $factura['valor_unitario'] . "</td>
                <td>" . $factura['valor_total'] . "</td>
                <td>" . ($factura['recibo_conforme'] == 1 ? 'Sí' : 'No') . "</td>
              </tr>";
    }

    echo "</tbody></table>";

} else {
    echo "<p>No hay facturas registradas.</p>";
}


$conn->close();
?>
