</section>
</div>

<footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; Narria 2025
        </div>
      </footer>
    </div>
  </div>


  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="<?= base_url('logout') ?>">Logout</a>
                </div>
            </div>
        </div>
  </div>

  <!-- General JS Scripts -->
  <script src="<?=base_url('assets')?>/modules/jquery.min.js"></script>
  <script src="<?=base_url('assets')?>/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?=base_url('assets')?>/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="<?=base_url('assets')?>/js/stisla.js"></script>

  <?= $this->renderSection('js')?>
  
  <!-- Template JS File -->
  <script src="<?=base_url('assets')?>/js/scripts.js"></script>
  <script src="<?=base_url('assets')?>/js/custom.js"></script>
</body>
</html>