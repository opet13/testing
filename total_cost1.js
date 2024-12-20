function updateTotalCost() {
            var studioSelect = document.getElementById('studio');
            var studioName = studioSelect.options[studioSelect.selectedIndex].text;
            var studioPrice = 0;

            // Set studio price based on selected studio
            switch (studioSelect.value) {
                case "Tap Dance":
                case "Irish Dance":
                    studioPrice = 40.00;
                    break;
                case "Clogging Dance":
                    studioPrice = 50.00;
                    break;
            }

            var extraFeeTotal = 0;
            var extraFees = document.querySelectorAll('input[name="equipment[]"]:checked');
            extraFees.forEach(function (item) {
                switch (item.value) {
                    case 'Speaker':
                    case 'Mirror':
                        extraFeeTotal += 15.00;
                        break;
                    case 'Tap Shoes':
                    case 'Hard Shoes':
                        extraFeeTotal += 100.00;
                        break;
                    case 'Clogging Shoes':
                        extraFeeTotal += 120.00;
                        break;
                }
            });
            var totalCost = studioPrice + extraFeeTotal;
            document.getElementById('totalCost').innerText = 'RM ' + totalCost.toFixed(2);
        }

        // Event listeners to update total cost on form field change
        document.getElementById('studio').addEventListener('change', updateTotalCost);
        var equipmentCheckboxes = document.querySelectorAll('input[name="equipment[]"]');
        equipmentCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', updateTotalCost);
        });

        // Initial call to update total cost
        updateTotalCost();
		
		