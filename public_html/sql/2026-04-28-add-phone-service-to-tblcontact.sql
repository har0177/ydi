-- Adds phone + service columns for Enquire Now modal submissions.
-- Both columns are nullable so existing contact form submissions remain valid.

ALTER TABLE tblcontact
  ADD COLUMN phone VARCHAR(32) NULL AFTER email,
  ADD COLUMN service VARCHAR(255) NULL AFTER phone;
