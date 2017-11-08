#! /usr/bin/python

import sys
reload(sys)
sys.setdefaultencoding('utf-8')

from selenium import webdriver

driver = webdriver.PhantomJS()
driver.get('seo_tmp_2.html')
data = driver.find_element_by_id("_").text
print data
driver.quit()