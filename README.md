# Hello

I've made the decision to stop hosting this website. 

This is intended as a developer release. If you are a developer, this project was developed with Laravel, and their resources are likely the best starting place for testing this project. While creating it, I mainly used Homestead with Vagrant and not Docker. I will not be accepting pull requests or managing issues in this repository. 

There is a Virtual Box .ova dump in this repository that should make it easy to test this project. It had been a while since I had tried to use the development environment included for Vagrant, and I found it to not be without issues when bringing the box up. Instead of fixing the Vagrantfile, I created a base image where everything does work in Virtual Box and exported it. It should work by just following the instructions below.

# Testing with the Virtual Box dump

1. Install [Virtual Box](https://www.virtualbox.org/wiki/Downloads)
2. Extract .ova file in the [vbox_dump](/vbox_dump) folder
3. Import into Virtual Box using the default

![1](https://github.com/TypingBooks/TypingBooks/assets/135349756/a5233c7b-c1f4-43e5-9019-f0b28427d7fb)

5. Boot the machine

![image](https://github.com/TypingBooks/TypingBooks/assets/135349756/220ad077-bb50-4f63-81a1-56b7ebdb75d8)

5. Visit http://localhost:8000 in a browser

![3](https://github.com/TypingBooks/TypingBooks/assets/135349756/97e3cd95-a7be-4432-a2d2-fcb3f91fafac)

# Typing practice with books. 

This introduction is copy/pasted from the old website that can be viewed at the [archive.org page here](https://web.archive.org/web/20210225081454/https://btype.io/).

![1a](https://github.com/TypingBooks/TypingBooks/assets/135349756/5348f039-800f-47c6-9c8c-e270a9b7e780)

![2a](https://github.com/TypingBooks/TypingBooks/assets/135349756/5943bfd9-dcd8-4b38-a9c9-5837cbd4d635)

# License

MIT
