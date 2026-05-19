<div class="modal fade" id="modal-access" tabindex="-1" role="dialog" aria-labelledby="modal-access" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-primary shadow-soft border-light p-4">
                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="card-header text-center pb-0">
                        <h2 class="mb-0 h5">Account access</h2>
                    </div>
                    <div class="card-body">
                        <form action="#">

                            <div class="d-flex align-items-center justify-content-between">
                                <label class="mb-0" for="customSwitch1">
                                    Toggle this switch element
                                </label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1"></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section bg-primary text-dark section-lg">
    <div class="container">
        <div class="row mt-5" id="account-container"></div>
    </div>
</div>

<script>
    $(function () {

        let isLoading = false;

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.innerText = text;
            return div.innerHTML;
        }

        async function loadAccount() {
            if (isLoading) return; // prevent double request
            isLoading = true;

            const container = document.getElementById('account-container');

            // loading state
            container.innerHTML = `<div class="col-12 text-center text-dark font-italic">Loading accounts...</div>`;

            try {
                const response = await fetch('home/process.php?action=fetch_account');
                const res = await response.json();

                if (!res || !res.status) {
                    container.innerHTML = `<div class="col-12 text-center text-dark font-italic">Failed to load accounts</div>`;
                    return;
                }

                if (!res.data || res.data.length === 0) {
                    container.innerHTML = `<div class="col-12 text-center text-dark font-italic">No accounts found</div>`;
                    return;
                }

                const fragment = document.createDocumentFragment();

                res.data.forEach(account => {
                    const accountName = escapeHtml(account.account_name);

                    const wrapper = document.createElement('div');
                    wrapper.className = "col-6 col-sm-6 col-lg-3 mb-5";

                    wrapper.innerHTML = `
                        <div class="btn-card card bg-primary border-light shadow-soft position-relative sub-account"
                            data-a-id="${account.a_id}"
                            data-account-name="${accountName}">
                            <div class="position-absolute" style="top: 12px; right: 12px;">
                                <button class="btn btn-link p-2" type="button" data-toggle="modal" data-target="#modal-access">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>

                            <div class="card-body">
                                <h6 class="h6 card-title mb-2">${accountName}</h6>
                                <p class="card-text mb-0"><b>+00,000,000.00</b></p>
                                <span class="icon-tertiary small">Balance</span>
                            </div>
                        </div>
                    `;

                    fragment.appendChild(wrapper);
                });

                container.innerHTML = "";
                container.appendChild(fragment);

            } catch (err) {
                console.error(err);
                container.innerHTML = `<div class="col-12 text-center text-dark font-italic">Error loading accounts</div>`;
            } finally {
                isLoading = false;
            }
        }

        let isRedirecting = false;

        $(document).on('click', '.sub-account', function (e) {
            // Clear any previous account ID on load
            sessionStorage.removeItem('a_id');
            sessionStorage.removeItem('account_id');

            // 🛑 Prevent modal trigger click (3 dots or inside button)
            if ($(e.target).closest('[data-toggle="modal"]').length) return;

            if (isRedirecting) return; // prevent double click spam
            isRedirecting = true;

            const accountId = $(this).data('a-id');
            const accountName = $(this).data('account-name');

            if (!accountId) {
                isRedirecting = false;
                return;
            }

            // 💡 Optional: add click feedback
            $(this).addClass('active');

            sessionStorage.setItem('a_id', accountId);
            sessionStorage.setItem('account_name', accountName);

            // slight delay for UX feel
            setTimeout(() => {
                window.location.href = `sub-account/`;
            }, 100);
        });

        // initial load
        loadAccount();

        // expose globally
        window.loadAccount = loadAccount;

    });
</script>