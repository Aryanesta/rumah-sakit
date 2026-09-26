import { SignInPage, Testimonial } from "@/components/ui/sign-in";

const sampleTestimonials: Testimonial[] = [
  {
    avatarSrc: "https://images.unsplash.com/photo-1594824813586-4f40f252cfb6?auto=format&fit=crop&w=150&q=80",
    name: "Ns. Siti Rahma, S.Kep",
    handle: "@perawat_sitirahma",
    text: "Sistem SIMRS memudahkan pencatatan tanda vital dan asuhan keperawatan secara akurat."
  },
  {
    avatarSrc: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80",
    name: "Budi Santoso",
    handle: "@pasien_budi",
    text: "Akses riwayat kontrol dan resep obat sangat transparan dan praktis."
  },
  {
    avatarSrc: "https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=150&q=80",
    name: "dr. Hendra Wijaya, Sp.PD",
    handle: "@dr_hendra",
    text: "Kolaborasi antara dokter, perawat, dan pasien menjadi jauh lebih efisien."
  },
];

const SignInPageDemo = () => {
  const handleSignIn = (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    const formData = new FormData(event.currentTarget);
    const data = Object.fromEntries(formData.entries());
    console.log("Sign In submitted:", data);
    alert(`Sign In Submitted! Check the browser console for form data.`);
  };

  const handleGoogleSignIn = () => {
    console.log("Continue with Google clicked");
    alert("Continue with Google clicked");
  };
  
  const handleResetPassword = () => {
    alert("Reset Password clicked");
  };

  const handleCreateAccount = () => {
    alert("Create Account clicked");
  };

  return (
    <div className="bg-background text-foreground">
      <SignInPage
        heroImageSrc="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1200&q=80"
        testimonials={sampleTestimonials}
        onSignIn={handleSignIn}
        onGoogleSignIn={handleGoogleSignIn}
        onResetPassword={handleResetPassword}
        onCreateAccount={handleCreateAccount}
      />
    </div>
  );
};

export default SignInPageDemo;
