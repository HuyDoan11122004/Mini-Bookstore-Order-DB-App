<section class="page-head">
    <div>
        <p class="eyebrow">Lab05 PHP Database CRUD</p>
        <h1>Mini Bookstore Order DB App</h1>
        <p class="lede">Manage bookstore prospects, book orders, unique order codes, search, pagination, safe sort, Repository SQL, PDO and friendly database errors.</p>
    </div>
    <a class="button primary" href="/prospects/create">New prospect</a>
</section>

<section class="metric-grid">
    <article class="metric">
        <span>Database</span>
        <strong>MySQL + PDO</strong>
        <p>utf8mb4, exception mode, assoc fetch and native prepares.</p>
    </article>
    <article class="metric">
        <span>Prospects</span>
        <strong>Email unique</strong>
        <p>Lead-style customer interest records for the bookstore.</p>
    </article>
    <article class="metric">
        <span>Orders</span>
        <strong>Code unique</strong>
        <p>Book orders protected by a database unique constraint.</p>
    </article>
    <article class="metric">
        <span>Performance</span>
        <strong>Index + EXPLAIN</strong>
        <p>Status/date and lookup indexes are included in schema.sql.</p>
    </article>
</section>

<section class="split">
    <article class="panel">
        <h2>Prospect CRM</h2>
        <p>Track potential bookstore customers by name, email, phone, interested genre and care status.</p>
        <div class="actions">
            <a class="button" href="/prospects">Open list</a>
            <a class="button subtle" href="/prospects/create">Create</a>
        </div>
    </article>

    <article class="panel">
        <h2>Book Orders</h2>
        <p>Manage order code, customer information, book title, quantity, amount and fulfillment status.</p>
        <div class="actions">
            <a class="button" href="/book-orders">Open list</a>
            <a class="button subtle" href="/book-orders/create">Create</a>
        </div>
    </article>
</section>
