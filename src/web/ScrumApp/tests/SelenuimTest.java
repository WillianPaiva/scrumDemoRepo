package com.example.tests;

import java.util.regex.Pattern;
import java.util.concurrent.TimeUnit;
import org.junit.*;
import static org.junit.Assert.*;
import static org.hamcrest.CoreMatchers.*;
import org.openqa.selenium.*;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;

public class SelenuimTest {
  private WebDriver driver;
  private String baseUrl;
  private boolean acceptNextAlert = true;
  private StringBuffer verificationErrors = new StringBuffer();

  @Before
  public void setUp() throws Exception {
    driver = new FirefoxDriver();
    baseUrl = "http://localhost:8000/";
    driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
  }

  @Test
  public void testSelenuim() throws Exception {
    driver.get(baseUrl + "/login");
    driver.findElement(By.linkText("Scrumk")).click();
    driver.findElement(By.cssSelector("button.navbar-toggle.collapsed")).click();
    driver.findElement(By.linkText("Login")).click();
    driver.findElement(By.id("email")).clear();
    driver.findElement(By.id("email")).sendKeys("hamza@gmail.com");
    driver.findElement(By.id("password")).clear();
    driver.findElement(By.id("password")).sendKeys("hamzaa");
    driver.findElement(By.cssSelector("button.btn.btn-primary")).click();
    driver.findElement(By.cssSelector("button.navbar-toggle.collapsed")).click();
    driver.findElement(By.linkText("hamza")).click();
    driver.findElement(By.linkText("profile")).click();
    driver.findElement(By.cssSelector("button.navbar-toggle.collapsed")).click();
    driver.findElement(By.linkText("hamza")).click();
    driver.findElement(By.cssSelector("li > a")).click();
    driver.findElement(By.cssSelector("i.fa.fa-pencil-square-o")).click();
    driver.findElement(By.id("language")).clear();
    driver.findElement(By.id("language")).sendKeys("Objective");
    driver.findElement(By.cssSelector("button.btn.btn-success")).click();
    driver.findElement(By.cssSelector("button.btn.btn-danger")).click();
    assertEquals("do you really want to delete Roslyn Stiedemann", closeAlertAndGetItsText());
    driver.findElement(By.cssSelector("i.fa.fa-external-link")).click();
    driver.findElement(By.name("user")).clear();
    driver.findElement(By.name("user")).sendKeys("hamza");
    driver.findElement(By.cssSelector("button.navbar-toggle.collapsed")).click();
    driver.findElement(By.cssSelector("li > a")).click();
    driver.findElement(By.cssSelector("i.fa.fa-external-link")).click();
    driver.findElement(By.cssSelector("button.btn.btn-danger")).click();
    driver.findElement(By.cssSelector("button.navbar-toggle.collapsed")).click();
    driver.findElement(By.cssSelector("li > a")).click();
    driver.findElement(By.cssSelector("button.btn.btn-danger")).click();
    assertEquals("do you really want to delete Durward Watsica", closeAlertAndGetItsText());
    driver.findElement(By.linkText("Scrumk")).click();
    driver.findElement(By.cssSelector("button.navbar-toggle.collapsed")).click();
    driver.findElement(By.linkText("hamza")).click();
    driver.findElement(By.linkText("Logout")).click();
  }

  @After
  public void tearDown() throws Exception {
    driver.quit();
    String verificationErrorString = verificationErrors.toString();
    if (!"".equals(verificationErrorString)) {
      fail(verificationErrorString);
    }
  }

  private boolean isElementPresent(By by) {
    try {
      driver.findElement(by);
      return true;
    } catch (NoSuchElementException e) {
      return false;
    }
  }

  private boolean isAlertPresent() {
    try {
      driver.switchTo().alert();
      return true;
    } catch (NoAlertPresentException e) {
      return false;
    }
  }

  private String closeAlertAndGetItsText() {
    try {
      Alert alert = driver.switchTo().alert();
      String alertText = alert.getText();
      if (acceptNextAlert) {
        alert.accept();
      } else {
        alert.dismiss();
      }
      return alertText;
    } finally {
      acceptNextAlert = true;
    }
  }
}
