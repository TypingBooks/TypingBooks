<?php 
return array (
  'accepted' => 'ต้องยอมรับ :attribute',
  'active_url' => ' :attribute ไม่ใช่ URL ที่ถูกต้อง',
  'after' => ' :attribute จะต้องเป็นวันที่หลัง :date',
  'after_or_equal' => ' :attribute จะต้องเป็นวันที่หลังหรือเท่ากับ :date',
  'alpha' => ' :attribute อาจมีตัวอักษรเท่านั้น',
  'alpha_dash' => ' :attribute อาจประกอบด้วยตัวอักษรตัวเลขเครื่องหมายขีดกลางและขีดล่างเท่านั้น',
  'alpha_num' => ' :attribute อาจมีเฉพาะตัวอักษรและตัวเลขเท่านั้น',
  'array' => ' :attribute จะต้องเป็นอาร์เรย์',
  'before' => ' :attribute ต้องเป็นวันที่ก่อน :date',
  'before_or_equal' => ' :attribute ต้องเป็นวันที่ก่อนหน้าหรือเท่ากับ :date',
  'between' => 
  array (
    'numeric' => ' :attribute จะต้องอยู่ระหว่าง :min ถึง :max',
    'file' => ' :attribute จะต้องอยู่ระหว่าง :min ถึง :max กิโลไบต์',
    'string' => ' :attribute จะต้องอยู่ระหว่าง :min และ :max ตัวอักษร',
    'array' => ' :attribute จะต้องมีอยู่ระหว่างรายการ :min และ :max',
  ),
  'boolean' => 'ฟิลด์ :attribute ต้องเป็นจริงหรือเท็จ',
  'confirmed' => 'การยืนยัน :attribute ไม่ตรงกัน',
  'date' => ' :attribute ไม่ใช่วันที่ที่ถูกต้อง',
  'date_equals' => ' :attribute ต้องเป็นวันที่เท่ากับ :date',
  'date_format' => ' :attribute ไม่ตรงกับรูปแบบ :format',
  'different' => ' :attribute และ :other ต้องแตกต่างกัน',
  'digits' => ' :attribute จะต้องเป็นตัวเลข :digits',
  'digits_between' => ' :attribute จะต้องอยู่ระหว่าง :min และ :max หลัก',
  'dimensions' => ' :attribute มีขนาดภาพที่ไม่ถูกต้อง',
  'distinct' => 'ฟิลด์ :attribute มีค่าซ้ำกัน',
  'email' => ' :attribute จะต้องเป็นที่อยู่อีเมลที่ถูกต้อง',
  'ends_with' => ' :attribute จะต้องลงท้ายด้วยหนึ่งในสิ่งต่อไปนี้: :values',
  'exists' => ' :attribute ที่เลือกไม่ถูกต้อง',
  'file' => ' :attribute จะต้องเป็นไฟล์',
  'filled' => 'ฟิลด์ :attribute ต้องมีค่า',
  'gt' => 
  array (
    'numeric' => ' :attribute จะต้องมากกว่า :value',
    'file' => ' :attribute จะต้องมากกว่า :value กิโลไบต์',
    'string' => ' :attribute จะต้องมากกว่า :value ตัวอักษร',
    'array' => ' :attribute จะต้องมีมากกว่า :value รายการ',
  ),
  'gte' => 
  array (
    'numeric' => ' :attribute จะต้องมากกว่าหรือเท่ากับ :value',
    'file' => ' :attribute จะต้องมากกว่าหรือเท่ากับ :value กิโลไบต์',
    'string' => ' :attribute ต้องมากกว่าหรือเท่ากับอักขระ 2 ตัว',
    'array' => ' :attribute จะต้องมีรายการ :value ขึ้นไป',
  ),
  'image' => ' :attribute จะต้องเป็นรูปภาพ',
  'in' => ' :attribute ที่เลือกไม่ถูกต้อง',
  'in_array' => 'ฟิลด์ :attribute ไม่มีอยู่ใน :other',
  'integer' => ' :attribute จะต้องเป็นจำนวนเต็ม',
  'ip' => ' :attribute จะต้องเป็นที่อยู่ IP ที่ถูกต้อง',
  'ipv4' => ' :attribute จะต้องเป็นที่อยู่ IPv4 ที่ถูกต้อง',
  'ipv6' => ' :attribute จะต้องเป็นที่อยู่ IPv6 ที่ถูกต้อง',
  'json' => ' :attribute จะต้องเป็นสตริง JSON ที่ถูกต้อง',
  'lt' => 
  array (
    'numeric' => ' :attribute จะต้องน้อยกว่า :value',
    'file' => ' :attribute จะต้องน้อยกว่า :value กิโลไบต์',
    'string' => ' :attribute ต้องน้อยกว่า :value ตัวอักษร',
    'array' => ' :attribute จะต้องมีรายการน้อยกว่า :value',
  ),
  'lte' => 
  array (
    'numeric' => ' :attribute จะต้องน้อยกว่าหรือเท่ากับ :value',
    'file' => ' :attribute จะต้องน้อยกว่าหรือเท่ากับ :value กิโลไบต์',
    'string' => ' :attribute ต้องน้อยกว่าหรือเท่ากับ :value ตัวอักษร',
    'array' => ' :attribute จะต้องไม่มีมากกว่า :value รายการ',
  ),
  'max' => 
  array (
    'numeric' => ' :attribute อาจไม่มากกว่า :max',
    'file' => ' :attribute อาจไม่มากกว่า :max กิโลไบต์',
    'string' => ' :attribute จะต้องไม่เกิน :max ตัวอักษร',
    'array' => ' :attribute อาจมีมากกว่า :max รายการไม่ได้',
  ),
  'mimes' => ' :attribute จะต้องเป็นไฟล์ประเภท: :values',
  'mimetypes' => ' :attribute จะต้องเป็นไฟล์ประเภท: :values',
  'min' => 
  array (
    'numeric' => ' :attribute จะต้องเป็นอย่างน้อย :min',
    'file' => ' :attribute จะต้องมีอย่างน้อย :min กิโลไบต์',
    'string' => ' :attribute ต้องมีอักขระอย่างน้อย :min ตัว',
    'array' => ' :attribute จะต้องมีอย่างน้อย :min รายการ',
  ),
  'not_in' => ' :attribute ที่เลือกไม่ถูกต้อง',
  'not_regex' => 'รูปแบบ :attribute ไม่ถูกต้อง',
  'numeric' => ' :attribute จะต้องเป็นตัวเลข',
  'password' => 'รหัสผ่านไม่ถูกต้อง',
  'present' => 'ต้องแสดงฟิลด์ :attribute',
  'regex' => 'รูปแบบ :attribute ไม่ถูกต้อง',
  'required' => 'ต้องระบุฟิลด์ :attribute',
  'required_if' => 'จำเป็นต้องมีฟิลด์ :attribute เมื่อ :other คือ :value',
  'required_unless' => 'จำเป็นต้องใช้ฟิลด์ :attribute ยกเว้นว่า :other อยู่ใน :values',
  'required_with' => 'จำเป็นต้องมีฟิลด์ :attribute เมื่อมี :values',
  'required_with_all' => 'จำเป็นต้องมีฟิลด์ :attribute เมื่อมี :values อยู่',
  'required_without' => 'ฟิลด์ :attribute จำเป็นต้องมีเมื่อไม่มี :values',
  'required_without_all' => 'จำเป็นต้องมีฟิลด์ :attribute เมื่อไม่มี :values อยู่',
  'same' => ' :attribute และ :other ต้องตรงกัน',
  'size' => 
  array (
    'numeric' => ' :attribute จะต้องเป็น :size',
    'file' => ' :attribute จะต้องเป็น :size กิโลไบต์',
    'string' => ' :attribute ต้องเป็นอักขระ :size',
    'array' => ' :attribute จะต้องมีรายการ :size',
  ),
  'starts_with' => ' :attribute จะต้องเริ่มต้นด้วยสิ่งใดสิ่งหนึ่งต่อไปนี้: :values',
  'string' => ' :attribute จะต้องเป็นสตริง',
  'timezone' => ' :attribute จะต้องเป็นโซนที่ถูกต้อง',
  'unique' => ' :attribute ได้ถูกใช้ไปแล้ว',
  'uploaded' => 'การอัปโหลด :attribute ล้มเหลว',
  'url' => 'รูปแบบ :attribute ไม่ถูกต้อง',
  'uuid' => ' :attribute จะต้องเป็น UUID ที่ถูกต้อง',
  'custom' => 
  array (
    'attribute-name' => 
    array (
      'rule-name' => 'ที่กำหนดเองข้อความ',
    ),
  ),
  'attributes' => 
  array (
  ),
);