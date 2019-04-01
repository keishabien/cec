-- select dentist --
SELECT distinct c.office_id, c.page_id, c.name, m.page_id, m.office_name, m.is_locum_dentist, m.dentist_name, m.dentist_strt_dt, m.dentist_end_dt,
                m.dentist_status, m.provider_no, m.is_in_leave, m.leave_strt_dt, m.leave_end_dt, m.emergency_number
FROM cec.office_details c, midwest_wrdp1.cec_update m
WHERE c.page_id = m.page_id AND m.dentist_name != "" AND m.office_name LIKE "%Dentist Office%";

INSERT into cec.dentist_details(office_id, `name`, provider_num, emergency_num, locum, start_date, end_date, `leave`, leave_start_date, leave_end_date, created_at)
VALUES(c.office_id, m.dentist_name, m.provider_num, m.emergency_num, m.is_locum_dentist, m.dentist_strt_dt, m.dentist_end_dt, m.is_in_leave, m.leave_srtr_dt, m.leave_end_dt,NOW())


-- ADD DENTIST DETAILS --
INSERT into cec.dentist_details(office_id, `name`, provider_num, emergency_num, locum, start_date, end_date, `leave`, leave_start_date, leave_end_date, created_at)
SELECT c.office_id, m.dentist_name, m.provider_no, m.emergency_number, m.is_locum_dentist, m.dentist_strt_dt, m.dentist_end_dt, m.is_in_leave, m.leave_strt_dt, m.leave_end_dt, NOW()
FROM cec.office_details c, midwest_wrdp1.cec_update m
WHERE c.page_id = m.page_id AND m.dentist_name != "" AND m.office_name LIKE "%Dentist Office%";


--select hygienist--
SELECT distinct c.office_id, c.page_id, c.name, m.page_id, m.office_name, m.hygienist
FROM cec.office_details c, midwest_wrdp1.cec_update m
WHERE c.page_id = m.page_id AND m.dentist_name != "" AND m.office_name LIKE "%Dentist Office%";

-- ADD HYGIENIST --
