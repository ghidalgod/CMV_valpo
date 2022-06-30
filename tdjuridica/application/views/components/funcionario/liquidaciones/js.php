<script>
	document.addEventListener("DOMContentLoaded", () => {
		const formulario = document.querySelector("#formPeriodo");
		
		formulario.addEventListener("submit", (e) => {
			e.preventDefault();
			const mesDesde = document.querySelector("#mesDesde").value;
			const mesHasta = document.querySelector("#mesHasta").value;
			const anioDesde = document.querySelector("#anioDesde").value;
			const anioHasta = document.querySelector("#anioHasta").value;
			const fechaDesde = new Date(anioDesde,mesDesde - 1,1).getTime();
			const fechaHasta = new Date(anioHasta,mesHasta - 1,1).getTime();

			if (fechaDesde > fechaHasta) {
				const hidden = document.querySelector(".hidden");
				
				if (hidden) {
					const divError = document.querySelector("#divError");
					divError.classList.remove("hidden");
					
					setTimeout(() => {
						divError.classList.add("hidden");	
					}, 3000);
				}

			} else {
				formulario.submit();
			}
		})
	});
</script>