
  

			<?php if($toast['status'] != ''){ ?>
	        <script>
					$.toast({
						heading: '<?php echo $toast['head']; ?>',
						text: '<?php echo $toast['text']; ?>',
						position: 'top-right',
						loaderBg:'#fec107',
						icon: '<?php echo $toast['status']; ?>',
						hideAfter: 3500,
						stack: 6
					});
	        </script>
	        <?php } ?>



</body>

</html>
