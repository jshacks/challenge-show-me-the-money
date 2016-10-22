# Domain

### Entity
- name
- identifier (CUI)
- email
- password
- password_salt
- created_at
- type: Watcher | Notifier | Admin

### Debtor
The person who has debts, but is also about to receive a payout
- external_id
- first_name
- last_name
- CNP (optional)
- birth_date

### Debt
- external_id (from Watcher Entity)
- amount
- debtor: Debtor
- entity: Entity (Watcher)
- reason
- created_at
- updated_at
- observations


### PayoutNotice
A notice that a debtor is about to receive money. Based on it, a Central can send alerts to the interested Locals
- debtor: Debtor
- author: Entity (Notifier)
- ref
- amount
- created_at
- observations
- designated_person
- bank_account

### Alert
- payout_notice : PayoutNotice
- watcher: Entity
- created_at
- seen: Bool
 
